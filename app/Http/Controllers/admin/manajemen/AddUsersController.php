<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AddUsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::where('name', '!=', 'admin')->get();
        return view('admin.manajemen.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'nullable|exists:roles,id',
            'name' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->role_id = $request->role_id;
        $user->name = $request->name;
        $user->nik = $request->nik;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'nullable|exists:roles,id',
            'name' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->name = $request->name;
        $user->nik = $request->nik;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
