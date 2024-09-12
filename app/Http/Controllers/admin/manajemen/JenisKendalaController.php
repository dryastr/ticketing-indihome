<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\JenisKendala;
use Illuminate\Http\Request;

class JenisKendalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisKendalas = JenisKendala::all();
        return view('admin.manajemen.jenis_kendala.index', compact('jenisKendalas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.manajemen.jenis_kendala.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kendala' => 'required|string|max:255',
        ]);

        JenisKendala::create($request->all());

        return redirect()->route('jenis_kendalas.index')->with('success', 'Jenis Kendala created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisKendala $jenisKendala)
    {
        return view('admin.manajemen.jenis_kendala.show', compact('jenisKendala'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisKendala $jenisKendala)
    {
        return view('admin.manajemen.jenis_kendala.edit', compact('jenisKendala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisKendala $jenisKendala)
    {
        $request->validate([
            'nama_kendala' => 'required|string|max:255',
        ]);

        $jenisKendala->update($request->all());

        return redirect()->route('jenis_kendalas.index')->with('success', 'Jenis Kendala updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisKendala $jenisKendala)
    {
        $jenisKendala->delete();

        return redirect()->route('jenis_kendalas.index')->with('success', 'Jenis Kendala deleted successfully.');
    }
}
