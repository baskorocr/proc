<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\masterData\Proses;

class ProsesController extends Controller
{
    public function index(Request $request)
    {
        $proses = Proses::all();
        return view('proses.index', compact('proses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk menambahkan proses baru
        return view('proses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'proses_name' => 'required|string|max:255',
        ]);

        // Menyimpan data proses baru
        Proses::create($validatedData);

        // Redirect ke halaman daftar proses dengan pesan sukses
        return redirect()->route('proses.index')->with('success', 'Proses berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Menampilkan detail proses tertentu
        $proses = Proses::findOrFail($id);
        return view('proses.show', compact('proses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Menampilkan form untuk mengedit proses
        $proses = Proses::findOrFail($id);
        return view('proses.edit', compact('proses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'proses_name' => 'required|string|max:255',
        ]);

        Proses::whereId($id)->update($validatedData);

        $redirectUrl = route('proses.index');
        $params = [];
        if ($request->has('page')) $params['page'] = $request->page;
        if ($request->has('search')) $params['search'] = $request->search;
        if (!empty($params)) $redirectUrl .= '?' . http_build_query($params);

        return redirect($redirectUrl)->with('success', 'Proses berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        Proses::destroy($id);

        $redirectUrl = route('proses.index');
        $params = [];
        if ($request->has('page')) $params['page'] = $request->page;
        if ($request->has('search')) $params['search'] = $request->search;
        if (!empty($params)) $redirectUrl .= '?' . http_build_query($params);

        return redirect($redirectUrl)->with('success', 'Proses berhasil dihapus');
    }
}