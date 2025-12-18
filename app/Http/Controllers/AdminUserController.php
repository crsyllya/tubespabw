<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        // Ambil semua user
        $users = User::all();

        // Tampilkan ke blade manageuser
        return view('admin.users.manageuser', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,penyelenggara,pengunjung',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        return redirect()->route('admin.user.manageuser')
            ->with('success','User berhasil ditambah');
    }

    public function toggle($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'Status user berhasil diubah.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success','User berhasil dihapus');
    }
}
