<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\masterData\Pemilik;

class PemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pemilik::query();
        
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name_pemilik', 'like', '%' . $searchTerm . '%');
        }
        
        $pemiliks = $query->paginate(10)->appends($request->query());
        return view('pemiliks.index', compact('pemiliks'));
    }

    public function create()
    {
        return view('pemiliks.create');
    }

  
    


    public function edit(Pemilik $pemilik)
    {
        return view('pemiliks.edit', compact('pemilik'));
    }
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_pemilik' => 'required|string|max:255',
        ]);

        Pemilik::create([
            'name_pemilik' => $request->name_pemilik,
        ]);

        return redirect()->route('pemiliks.index')->with('success', 'Pemilik berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_pemilik' => 'required|string|max:255',
        ]);

        $pemilik = Pemilik::findOrFail($id);
        $pemilik->update([
            'name_pemilik' => $request->name_pemilik,
        ]);

        $redirectUrl = route('pemiliks.index');
        $params = [];
        if ($request->has('page')) $params['page'] = $request->page;
        if ($request->has('search')) $params['search'] = $request->search;
        if (!empty($params)) $redirectUrl .= '?' . http_build_query($params);

        return redirect($redirectUrl)->with('success', 'Pemilik berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $pemilik = Pemilik::findOrFail($id);
        $pemilik->delete();

        $redirectUrl = route('pemiliks.index');
        $params = [];
        if ($request->has('page')) $params['page'] = $request->page;
        if ($request->has('search')) $params['search'] = $request->search;
        if (!empty($params)) $redirectUrl .= '?' . http_build_query($params);

        return redirect($redirectUrl)->with('success', 'Pemilik berhasil dihapus.');
    }
}