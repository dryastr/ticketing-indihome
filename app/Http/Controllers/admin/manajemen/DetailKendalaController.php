<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\DetailKendala;
use App\Models\JenisKendala;
use Illuminate\Http\Request;

class DetailKendalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detailKendalas = DetailKendala::with('jenisKendala')->get();
        $jenisKendalas = JenisKendala::all();
        return view('admin.manajemen.detail_kendala.index', compact('detailKendalas', 'jenisKendalas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisKendalas = JenisKendala::all();

        return view('admin.manajemen.detail_kendala.create', compact('jenisKendalas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_kendala_id' => 'required|exists:jenis_kendalas,id',
            'detail_kendala' => 'required',
        ]);

        DetailKendala::create($request->all());

        return redirect()->route('detail_kendalas.index')->with('success', 'Detail Kendala created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detailKendala = DetailKendala::findOrFail($id);
        return view('admin.manajemen.detail_kendala.show', compact('detailKendala'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $detailKendala = DetailKendala::findOrFail($id);
        $jenisKendalas = JenisKendala::all();
        return view('admin.manajemen.detail_kendala.edit', compact('detailKendala', 'jenisKendalas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis_kendala_id' => 'required|exists:jenis_kendalas,id',
            'detail_kendala' => 'required',
        ]);

        $detailKendala = DetailKendala::findOrFail($id);
        $detailKendala->update($request->all());

        return redirect()->route('detail_kendalas.index')->with('success', 'Detail Kendala updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $detailKendala = DetailKendala::findOrFail($id);
        $detailKendala->delete();

        return redirect()->route('detail_kendalas.index')->with('success', 'Detail Kendala deleted successfully.');
    }
}
