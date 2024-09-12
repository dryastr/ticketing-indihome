<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Models\JenisKendala;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('user', 'teknisi', 'jenisKendala')->get();
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->get();
        $teknisis = User::whereHas('role', function ($query) {
            $query->where('name', 'teknisi');
        })->get();
        $jenisKendalas = JenisKendala::all();
        return view('admin.manajemen.tickets.index', compact('tickets', 'users', 'jenisKendalas', 'teknisis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $jenisKendalals = JenisKendala::all();
        return view('admin.manajemen.tickets.create', compact('users', 'jenisKendalals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik_id' => 'required|exists:users,id',
            'pelanggan_id' => 'required|exists:users,id',
            'jenis_kendala_id' => 'required|exists:jenis_kendalas,id',
            'STO' => 'required|string|max:20',
            'status' => 'required|boolean',
        ]);

        Ticket::create($request->all());
        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('admin.manajemen.tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $users = User::all();
        $jenisKendalals = JenisKendala::all();
        return view('admin.manajemen.tickets.edit', compact('ticket', 'users', 'jenisKendalals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'nik_id' => 'required|exists:users,id',
            'pelanggan_id' => 'required|exists:users,id',
            'jenis_kendala_id' => 'required|exists:jenis_kendalas,id',
            'STO' => 'required|string|max:20',
            'status' => 'required|boolean',
        ]);

        $ticket->update($request->all());
        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }
}
