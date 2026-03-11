<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\masterData\Asset;
use App\Models\masterData\Part;
use App\Models\Vendor;
use App\Models\masterData\Project;
use App\Models\masterData\AssetType;
use App\Models\masterData\Pemilik;
use App\Models\masterData\Riwayat;
use Illuminate\Support\Facades\Validator; 
use App\Models\masterData\Proses;
use App\Models\MasterUser;
use App\Models\scheduleKunjungan;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;




class AssetsController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::with(['vendor', 'project.customer', 'assetType', 'pemilik', 'part', 'user']);
        
        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('no_assets', 'regex', new \MongoDB\BSON\Regex($searchTerm, 'i'))
                  ->orWhereHas('project.customer', function($subQ) use ($searchTerm) {
                      $subQ->where('name', 'regex', new \MongoDB\BSON\Regex($searchTerm, 'i'));
                  })
                  ->orWhereHas('part', function($subQ) use ($searchTerm) {
                      $subQ->where('part_name', 'regex', new \MongoDB\BSON\Regex($searchTerm, 'i'));
                  });
            });
        }
        
        $assets = $query->paginate(15);

        // Ambil semua vendor dan pemilik
        $vendors = Vendor::all();
        $owners = Pemilik::all();

        return view('assets.index', compact('assets', 'vendors', 'owners'));
    }
    /**
     * Show the form for creating a new resource.
     */


    public function search(Request $request)
    {
        $searchTerm = $request->search;
        $data = '';

        if (!empty($searchTerm)) {
            $assets = Asset::with(['project.customer', 'vendor', 'part', 'assetType', 'pemilik'])
                ->whereHas('project.customer', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', '%' . $searchTerm . '%');
                })
                ->orWhere('no_assets', 'LIKE', '%' . $searchTerm . '%')
                ->get();

            if ($assets->isEmpty()) {
                $data .= '<tr><td colspan="16" class="text-center">No data found.</td></tr>';
            } else {
                foreach ($assets as $key => $asset) {
                    $data .= '<tr>' .
                        '<td>' . ($key + 1) . '</td>' .
                        '<td>' . $asset->project->customer->name . '</td>' .
                        '<td>' . $asset->project->name_project . '</td>' .
                        '<td>' . optional($asset->vendor)->name_vendor . '</td>' .
                        '<td></td>' .
                        '<td>' . $asset->part->part_name . '</td>' .
                        '<td>' . $asset->part->idPart . '</td>' .
                        '<td>' . $asset->part->spek_material . '</td>' .
                        '<td>' . $asset->assetType->name_type . '</td>' .
                        '<td>' . $asset->Proses . '</td>' .
                        '<td>' . $asset->no_assets . '</td>' .
                        '<td>' . $asset->assetType->name_type . '</td>' .
                        '<td>' . $asset->jumlah . '</td>' .
                        '<td>' . $asset->machine . '</td>' .
                        '<td>' . optional($asset->pemilik)->name_pemilik . '</td>' .
                        '<td>' .
                        '<a href="' . route('assetsPart.edit', $asset->no_assets) . '" class="btn btn-warning btn-sm">Pindah Asset</a>' .
                        '<form action="' . route('assetsPart.destroy', $asset->no_assets) . '" method="POST" style="display:inline;">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>' .
                        '</form>' .
                        '</td>' .
                        '</tr>';
                }
            }
        } else {
            $assets = Asset::with(['project.customer', 'vendor', 'part', 'assetType', 'pemilik'])
                ->paginate(10);

            if ($assets->isEmpty()) {
                $data .= '<tr><td colspan="16" class="text-center">No data found.</td></tr>';
            } else {
                foreach ($assets as $key => $asset) {
                    $data .= '<tr>' .
                        '<td>' . ($key + 1) . '</td>' .
                        '<td>' . $asset->project->customer->name . '</td>' .
                        '<td>' . $asset->project->name_project . '</td>' .
                        '<td>' . optional($asset->vendor)->name_vendor . '</td>' .
                        '<td></td>' .
                        '<td>' . $asset->part->part_name . '</td>' .
                        '<td>' . $asset->part->idPart . '</td>' .
                        '<td>' . $asset->part->spek_material . '</td>' .
                        '<td>' . $asset->assetType->name_type . '</td>' .
                        '<td>' . $asset->Proses . '</td>' .
                        '<td>' . $asset->no_assets . '</td>' .
                        '<td>' . $asset->assetType->name_type . '</td>' .
                        '<td>' . $asset->jumlah . '</td>' .
                        '<td>' . $asset->machine . '</td>' .
                        '<td>' . optional($asset->pemilik)->name_pemilik . '</td>' .
                        '<td>' .
                        '<a href="' . route('assetsPart.edit', $asset->no_assets) . '" class="btn btn-warning btn-sm">Pindah Asset</a>' .
                        '<form action="' . route('assetsPart.destroy', $asset->no_assets) . '" method="POST" style="display:inline;">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>' .
                        '</form>' .
                        '</td>' .
                        '</tr>';
                }
            }
        }

        return response()->json($data);
    }


    public function create()
    {
        $proses = Proses::all();
        $projects = Project::all();
        $pemiliks = Pemilik::all();
        $parts = Part::all();
        
        // Try to get vendors with error handling
        try {
            $vendors = Vendor::all();
        } catch (\Exception $e) {
            // Fallback with hardcoded vendors if database connection fails
            $vendors = collect([
                (object)['id_vendor' => '100049', 'nm_vendor' => 'AHSUNG ABADI PERKASA, PT'],
                (object)['id_vendor' => '100006', 'nm_vendor' => 'DUTA KIMIA BERJAYA, PT'],
                (object)['id_vendor' => '100001', 'nm_vendor' => 'DHARMA POLIMETAL, PT'],
            ]);
        }

        return view('assets.create', compact('projects', 'pemiliks', 'parts', 'proses', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_assets' => 'nullable|string|max:255',
            'project_id' => 'required|exists:projects,_id',
            'vendor_id' => 'nullable',
            'pemiliks_id' => 'nullable|exists:pemiliks,_id',
            'idPart' => 'required',
            'jumlah' => 'required|integer',
            'proses_id' => 'required|array',
            'proses_id.*' => 'exists:proses,_id',
            'machine' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Asset::create([
            'no_assets' => $request->no_assets,
            'vendor_id' => $request->vendor_id ?: null,
            'project_id' => $request->project_id,
            'pemiliks_id' => $request->pemiliks_id ?: null, 
            'idPart' => $request->idPart,
            'idUser' => null,
            'jumlah' => $request->jumlah,
            'proses_id' => $request->proses_id,
            'machine' => $request->machine,
            'dies' => $request->dies,
            'Cavity' => $request->Cavity
        ]);

        return redirect()->route('assetsPart.index')
            ->with('success', 'Asset created successfully.');
    }

    public function import(Request $request)
    {
        try {
            $file = $request->file('excel_file');
            $data = \Maatwebsite\Excel\Facades\Excel::toArray([], $file)[0];
            
            if (empty($data)) {
                return redirect()->back()->with('error', 'Excel file is empty.');
            }
            
            array_shift($data); // Skip header
            
            $successCount = 0;
            $errors = [];
            
            foreach ($data as $index => $row) {
                $rowNumber = $index + 2;
                
                if (!is_array($row) || empty(array_filter($row))) continue;
                
                try {
                    $missingData = [];
                    
                    // Validate Vendor
                    $vendorId = isset($row[2]) ? trim($row[2]) : null;
                    $vendor = $vendorId ? Vendor::where('id_vendor', $vendorId)->first() : null;
                    if($vendorId && !$vendor) {
                        $missingData[] = "Vendor ID: {$vendorId}";
                    }
                    
                    // Validate Project
                    $projectName = isset($row[3]) ? trim($row[3]) : null;
                    $project = $projectName ? Project::where('name_project', $projectName)->first() : null;
                    if($projectName && !$project) {
                        $missingData[] = "Project: {$projectName}";
                    }
                    
                    // Validate Part
                    $partId = isset($row[4]) ? trim($row[4]) : null;
                    $part = $partId ? Part::where('idPart', $partId)->first() : null;
                    if($partId && !$part) {
                        $missingData[] = "Part ID: {$partId}";
                    }
                    
                    // Find Dies/CF column
                    $diesIndex = null;
                    for($i = 5; $i < count($row); $i++) {
                        $val = isset($row[$i]) ? strtolower(trim($row[$i])) : '';
                        if($val === 'dies' || $val === 'cf') {
                            $diesIndex = $i;
                            break;
                        }
                    }
                    
                    if($diesIndex === null) continue;
                    
                    // Validate and collect proses
                    $prosesIds = [];
                    $missingProses = [];
                    for($i = 5; $i < $diesIndex; $i++) {
                        if(isset($row[$i]) && !empty(trim($row[$i]))) {
                            $prosesName = trim($row[$i]);
                            // Try exact match first
                            $proses = Proses::where('proses_name', $prosesName)->first();
                            // If not found, try case-insensitive
                            if(!$proses) {
                                $proses = Proses::whereRaw(['proses_name' => ['$regex' => '^' . preg_quote($prosesName) . '$', '$options' => 'i']])->first();
                            }
                            if($proses) {
                                $prosesIds[] = (string)$proses->_id;
                            } else {
                                $missingProses[] = $prosesName;
                            }
                        }
                    }
                    
                    if(!empty($missingProses)) {
                        $missingData[] = "Proses: " . implode(', ', $missingProses);
                    }
                    
                    // If any data is missing, add to errors and skip
                    if(!empty($missingData)) {
                        $errors[] = "Row {$rowNumber}: Data not found - " . implode(' | ', $missingData);
                        continue;
                    }
                    
                    $pemilik = null;
                    if (isset($row[$diesIndex + 4]) && !empty($row[$diesIndex + 4])) {
                        $pemilik = Pemilik::where('name_pemilik', $row[$diesIndex + 4])->first();
                    }
                    
                    Asset::create([
                        'no_assets' => isset($row[1]) ? (string)$row[1] : '',
                        'vendor_id' => $vendor ? (string)$vendor->id_vendor : null,
                        'project_id' => $project ? (string)$project->_id : null,
                        'idPart' => $partId ?: null,
                        'proses_id' => !empty($prosesIds) ? $prosesIds : null,
                        'pemiliks_id' => $pemilik ? (string)$pemilik->_id : null,
                        'dies' => trim($row[$diesIndex]),
                        'machine' => isset($row[$diesIndex + 1]) ? (string)$row[$diesIndex + 1] : '',
                        'jumlah' => isset($row[$diesIndex + 2]) ? (int)$row[$diesIndex + 2] : 0,
                        'Cavity' => isset($row[$diesIndex + 3]) ? (int)$row[$diesIndex + 3] : 0,
                    ]);
                    
                    // Create schedule kunjungan (2 months from now)
                    $noAsset = isset($row[1]) ? (string)$row[1] : '';
                    if($noAsset) {
                        \App\Models\scheduleKunjungan::create([
                            'asset_id' => $noAsset,
                            'waktu_kunjungan' => \Carbon\Carbon::now()->addMonths(2)->format('Y-m-d'),
                            'idUser' => auth()->user()->id ?? null
                        ]);
                    }
                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Row {$rowNumber}: " . $e->getMessage();
                }
            }
            
            if (!empty($errors)) {
                return redirect()->back()
                    ->withErrors(['import' => $errors])
                    ->with('success', "Imported {$successCount} assets with some errors.");
            }
            
            return redirect()->route('assetsPart.index')
                ->with('success', "Successfully imported {$successCount} assets.");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        return view('assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $asset = Asset::findOrFail($id);

        // Retrieve related data for the form
        $pemiliks = Pemilik::all();
        $projects = Project::all();
        $parts = Part::all();
        $proses = Proses::all();
        
        // Try to get vendors with error handling
        try {
            $vendors = Vendor::all();
        } catch (\Exception $e) {
            // Fallback with hardcoded vendors if database connection fails
            $vendors = collect([
                (object)['id_vendor' => '100049', 'nm_vendor' => 'AHSUNG ABADI PERKASA, PT'],
                (object)['id_vendor' => '100006', 'nm_vendor' => 'DUTA KIMIA BERJAYA, PT'],
                (object)['id_vendor' => '100001', 'nm_vendor' => 'DHARMA POLIMETAL, PT'],
            ]);
        }

        // Return the view with the asset and related data
        return view('assets.edit', compact('asset', 'pemiliks', 'projects', 'parts', 'proses', 'vendors'));
    }

    // Handle the form submission and update the asset in the database
    public function update(Request $request, $id)
    {
        try{
            // Validate the request data
            $validated =  $request->validate([
                'no_assets'    => 'required|string|max:255',
                'project_id'   => 'required',
                'pemiliks_id'  => 'nullable',
                'idPart'       => 'required|string|max:255',
                'proses_id'    => 'required|exists:proses,_id',
                'machine'      => 'required|string|max:255',
                'jumlah'       => 'required|integer|min:1',
            ]);

            // Find the existing asset by its primary key
            $asset = Asset::findOrFail($id);

            $asset->update([
                'no_assets'     => $validated['no_assets'],
                'project_id'    => $validated['project_id'],
                'pemiliks_id'   => $validated['pemiliks_id'] ?: null,
                'idPart'        => $validated['idPart'],
                'proses_id'     => $validated['proses_id'],
                'machine'       => $validated['machine'],
                'jumlah'        => $validated['jumlah'],
                'idUser'        => null,
                'dies'          => $request->dies,
                'Cavity'        => $request->Cavity
            ]);

            // Build redirect URL with preserved parameters
            $redirectUrl = route('assetsPart.index');
            $params = [];
            if ($request->has('page')) $params['page'] = $request->page;
            if ($request->has('search')) $params['search'] = $request->search;
            if (!empty($params)) $redirectUrl .= '?' . http_build_query($params);

            // Redirect the user with a success message
            return redirect($redirectUrl)->with('success', 'Asset updated successfully!');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('assetsPart.index')->with('error', 'There was an error during Update: ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        // Build redirect URL with preserved parameters
        $redirectUrl = route('assetsPart.index');
        $params = [];
        if ($request->has('page')) $params['page'] = $request->page;
        if ($request->has('search')) $params['search'] = $request->search;
        if (!empty($params)) $redirectUrl .= '?' . http_build_query($params);

        return redirect($redirectUrl)->with('success', 'Asset deleted successfully.');
     }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No assets selected']);
        }
        
        try {
            Asset::whereIn('_id', $ids)->delete();
            return response()->json(['success' => true, 'message' => count($ids) . ' assets deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function move(Request $request, $no_assets)
    {
     
   



       $validator = Validator::make($request->all(), [
        'no_assets' => 'required|string',
        
        'new_vendor_id' => 'required|string',
        'jumlah' => 'required|integer',
        'bukti_pemindahan' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
    ]);
    

        if ($validator->fails()) {
           
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try{
            $asset = Asset::where('no_assets', $request->no_assets)->firstOrFail();
            if ($request->hasFile('bukti_pemindahan')) {
                $file = $request->file('bukti_pemindahan');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/bukti', $namaFile); // atau sesuaikan pathnya
            } else {
                $namaFile = null;
            }
           $p =  Riwayat::create([
                'no_assets' => $request->no_assets,
                'idUser' => auth()->user()->id,
                'StatusAwal' => $request->old_vendor_id,
                'StatusAkhir' => $request->new_vendor_id,
                'jumlah' => $request->jumlah,
                'bukti' => $namaFile,
            ]);
       

        
            $asset->update([
                'vendor_id' => $request->new_vendor_id,
            ]);
            $target = Carbon::now('Asia/Jakarta')
            ->addMonthsNoOverflow(2)
            ->timezone('UTC')
            ->format('d-m-Y');

            scheduleKunjungan::create([
                'asset_id' => $request->no_assets,
                'idUser' => auth()->user()->id,
                'waktu_kunjungan' => $target, 
            ]);


    
    
    
            return redirect()->back()->with('success', 'Asset moved successfully.');

        }
        catch(\Exception $e){
            return redirect()->back()->with('error', 'There was an error during move: ' . $e->getMessage());
        }
      
    }

    public function export(Request $request)
    {
        $query = Asset::with(['vendor', 'project.customer', 'assetType', 'pemilik', 'part']);
        
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            
            // Simple search on main fields only
            $assets = Asset::with(['vendor', 'project.customer', 'assetType', 'pemilik', 'part'])
                ->where(function($q) use ($searchTerm) {
                    $q->where('no_assets', 'regex', new \MongoDB\BSON\Regex($searchTerm, 'i'))
                      ->orWhere('machine', 'regex', new \MongoDB\BSON\Regex($searchTerm, 'i'));
                })
                ->get();
        } else {
            $assets = $query->get();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'No. Asset');
        $sheet->setCellValue('C1', 'Vendor');
        $sheet->setCellValue('D1', 'Customer');
        $sheet->setCellValue('E1', 'Project');
        $sheet->setCellValue('F1', 'Owner');
        $sheet->setCellValue('G1', 'Part ID');
        $sheet->setCellValue('H1', 'Part Name');
        $sheet->setCellValue('I1', 'Dies');
        $sheet->setCellValue('J1', 'Process');
        $sheet->setCellValue('K1', 'Cavity');
        $sheet->setCellValue('L1', 'Machine');
        $sheet->setCellValue('M1', 'Quantity');
        
        // Data
        $row = 2;
        foreach ($assets as $index => $asset) {
            // Handle proses
            $prosesName = '-';
            if(is_array($asset->proses_id)) {
                $prosesNames = [];
                foreach($asset->proses_id as $pid) {
                    $p = Proses::find($pid);
                    if($p) $prosesNames[] = $p->proses_name;
                }
                $prosesName = !empty($prosesNames) ? implode(', ', $prosesNames) : '-';
            } elseif($asset->proses_id) {
                $p = Proses::find($asset->proses_id);
                $prosesName = $p ? $p->proses_name : '-';
            }
            
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $asset->no_assets ?? '-');
            $sheet->setCellValue('C' . $row, optional($asset->vendor)->nm_vendor ?? '-');
            $sheet->setCellValue('D' . $row, $asset->project && $asset->project->customer ? $asset->project->customer->name : '-');
            $sheet->setCellValue('E' . $row, optional($asset->project)->name_project ?? '-');
            $sheet->setCellValue('F' . $row, optional($asset->pemilik)->name_pemilik ?? '-');
            $sheet->setCellValue('G' . $row, optional($asset->part)->idPart ?? '-');
            $sheet->setCellValue('H' . $row, optional($asset->part)->part_name ?? $asset->idPart ?? '-');
            $sheet->setCellValue('I' . $row, (!empty($asset->dies) && $asset->dies !== 'nan') ? $asset->dies : '-');
            $sheet->setCellValue('J' . $row, $prosesName);
            $sheet->setCellValue('K' . $row, (!empty($asset->Cavity) && $asset->Cavity !== 'nan') ? $asset->Cavity : '-');
            $sheet->setCellValue('L' . $row, $asset->machine ?? '-');
            $sheet->setCellValue('M' . $row, $asset->jumlah ?? '-');
            $row++;
        }
        
        $writer = new Xlsx($spreadsheet);
        $filename = 'assets_' . date('YmdHis') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}