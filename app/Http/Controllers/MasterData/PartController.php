<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\masterData\Part;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;



class PartController extends Controller
{
    public function index(Request $request)
    {
        $parts = Part::all();
        return view('parts.index', compact('parts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show the form to create a new part
        return view('parts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'part_name' => 'required|string|max:255',
            'spek_material' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file upload
        $data = $request->all();
        
        if ($request->hasFile('photo')) {
            // Check if the uploads directory exists, if not create it
            if (!Storage::exists('public/parts')) {
                Storage::makeDirectory('public/parts');
            }
            
            // Get the file from the request
            $file = $request->file('photo');
            
            // Generate a unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Store the file in the storage/app/public/parts directory
            $file->storeAs('public/parts', $filename);
            
            // Save the filename to the database
            $data['photo'] = $filename;
        }

        // Create a new part
        Part::create($data);

        // Redirect to parts list with success message
        return redirect()->route('parts.index')->with('success', 'Part created successfully.');
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Try different data types for MongoDB compatibility
        $part = Part::where('idPart', $id)
                   ->orWhere('idPart', (int)$id)
                   ->orWhere('idPart', (string)$id)
                   ->first();
        
        if (!$part) {
            abort(404, 'Part not found with idPart: ' . $id);
        }
        
        return view('parts.edit', compact('part'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'part_name' => 'required|string|max:255',
            'spek_material' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $part = Part::where('idPart', $id)
                   ->orWhere('idPart', (int)$id)
                   ->orWhere('idPart', (string)$id)
                   ->first();
        
        if (!$part) {
            abort(404, 'Part not found with idPart: ' . $id);
        }
        $part->part_name = $validatedData['part_name'];
        $part->spek_material = $validatedData['spek_material'];

        if ($request->hasFile('photo')) {
            if (!Storage::exists('public/parts')) {
                Storage::makeDirectory('public/parts');
            }
            
            if ($part->photo && Storage::exists('public/parts/' . $part->photo)) {
                Storage::delete('public/parts/' . $part->photo);
            }
            
            $file = $request->file('photo');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/parts', $filename);
            $part->photo = $filename;
        }

        $part->save();

        $redirectUrl = route('parts.index');
        $params = [];
        if ($request->has('page')) $params['page'] = $request->page;
        if ($request->has('search')) $params['search'] = $request->search;
        if (!empty($params)) $redirectUrl .= '?' . http_build_query($params);

        return redirect($redirectUrl)->with('success', 'Part updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $part = Part::where('idPart', $id)
                   ->orWhere('idPart', (int)$id)
                   ->orWhere('idPart', (string)$id)
                   ->first();
        
        if (!$part) {
            abort(404, 'Part not found with idPart: ' . $id);
        }
        
        if ($part->photo && Storage::exists('public/parts/' . $part->photo)) {
            Storage::delete('public/parts/' . $part->photo);
        }
        
        $part->delete();

        $redirectUrl = route('parts.index');
        $params = [];
        if ($request->has('page')) $params['page'] = $request->page;
        if ($request->has('search')) $params['search'] = $request->search;
        if (!empty($params)) $redirectUrl .= '?' . http_build_query($params);

        return redirect($redirectUrl)->with('success', 'Part deleted successfully.');
    }

    public function syncFromSap()
{
    try {

        $materialTypes = ['ZOHP', 'ZSEM', 'ZFIN'];
        $purchGroups   = ['BJ2', 'BB1'];

        $allData = [];

        foreach ($materialTypes as $type) {

            $response = Http::withBasicAuth(
                config('sap.username'),
                config('sap.password')
            )->get(config('sap.api_url') . config('sap.api_endpoint'), [
                'PLANT'         => '1101',
                'purch_group'   => $purchGroups,
                'material_type' => $type, // kirim 1 per request
                'sap-client'    => '300'
            ]);

            if (!$response->successful()) {
                continue; // lanjut type berikutnya
            }

           
            $data = $response->json();

            if (isset($data['it_output']) && is_array($data['it_output'])) {
                $allData = array_merge($allData, $data['it_output']);
            }
        }
        

        if (empty($allData)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data diterima dari SAP'
            ], 500);
        }

        // Hapus lama
        Part::truncate();

        // Siapkan bulk insert
        $insertData = [];

        foreach ($allData as $item) {

            // Double safety filter
            if (!in_array($item['material_type'] ?? '', ['ZOHP', 'ZSEM', 'ZFIN'])) {
                continue;
            }

            $insertData[] = [
                'idPart'        => $item['material_no'] ?? '',
                'part_name'     => $item['short_text'] ?? '',
                'spek_material' => $item['material_type'] ?? '',
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }

        // Hindari duplicate material_no
        $insertData = collect($insertData)
            ->unique('idPart')
            ->values()
            ->toArray();

        Part::insert($insertData);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disinkronkan dari SAP (' . count($insertData) . ' records)'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}