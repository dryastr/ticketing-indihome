<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Teknisi;
use App\Models\User;
use Illuminate\Http\Request;

class TeknisisController extends Controller
{
    public function index()
    {
        $teknisis = Teknisi::all();

        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'teknisi');
        })->get();

        return view('admin.manajemen.teknisis.index', compact('teknisis', 'users'));
    }

    public function create()
    {
        return view('admin.manajemen.teknisis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_mitra' => 'required|string|max:255',
        ]);

        Teknisi::create($request->all());

        return redirect()->route('teknisis.index')->with('success', 'Teknisi created successfully.');
    }

    public function show(string $id)
    {
        $teknisi = Teknisi::findOrFail($id);
        return view('admin.manajemen.teknisis.show', compact('teknisi'));
    }

    public function edit(string $id)
    {
        $teknisi = Teknisi::findOrFail($id);
        return view('admin.manajemen.teknisis.edit', compact('teknisi'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_mitra' => 'required|string|max:255',
        ]);

        $teknisi = Teknisi::findOrFail($id);
        $teknisi->update($request->all());

        return redirect()->route('teknisis.index')->with('success', 'Teknisi updated successfully.');
    }

    public function destroy(string $id)
    {
        $teknisi = Teknisi::findOrFail($id);
        $teknisi->delete();

        return redirect()->route('teknisis.index')->with('success', 'Teknisi deleted successfully.');
    }
}
