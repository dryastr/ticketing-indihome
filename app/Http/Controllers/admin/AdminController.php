<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;

class AdminController extends Controller
{
    public function index()
    {
        // Count users based on their roles
        $userCount = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->count();

        $teknisiCount = User::whereHas('role', function ($query) {
            $query->where('name', 'teknisi');
        })->count();

        // Count total tickets
        $ticketCount = Ticket::count();

        // Pass the counts to the view
        return view('admin.dashboard', compact('userCount', 'teknisiCount', 'ticketCount'));
    }
}
