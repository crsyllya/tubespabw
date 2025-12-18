<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyelenggara;
use App\Models\Pengunjung;

class ManageUserController extends Controller
{
    // Menampilkan semua user dari 2 tabel (tanpa Admin)
public function index()
{
    $penyelenggaras = Penyelenggara::all()->map(function ($user) {
        $user->role = 'Penyelenggara';
        $user->name = $user->name ?? $user->nama ?? 'Penyelenggara ' . $user->id;
        return $user;
    });

    $pengunjungs = Pengunjung::all()->map(function ($user) {
        $user->role = 'Pengunjung';
        $user->name = $user->name ?? $user->nama ?? 'Pengunjung ' . $user->id;
        return $user;
    });

    // Gabungkan dengan cara yang lebih aman
    $users = collect();
    $users = $users->merge($penyelenggaras);
    $users = $users->merge($pengunjungs);

    return view('admin.user.manageuser', compact('users'));
}
    // Hapus user (hanya penyelenggara dan pengunjung)
    public function destroy($id)
    {
        if ($user = Penyelenggara::find($id)) {
            $user->delete();
        } elseif ($user = Pengunjung::find($id)) {
            $user->delete();
        }

        return back()->with('success', 'User berhasil dihapus.');
    }

    // Toggle aktif / nonaktif (hanya penyelenggara dan pengunjung)
     public function toggleActive($role, $id)
{
    $role = strtolower($role);
    
    if ($role == 'penyelenggara') {
        $user = Penyelenggara::find($id);
    } else {
        $user = Pengunjung::find($id);
    }

    if (!$user) {
        return back()->with('error', 'User tidak ditemukan.');
    }

    // Pastikan pakai is_active (bukan is_sctive)
    $user->is_active = !$user->is_active;
    $user->save();

    return back()->with('success', 'Status user berhasil diubah.');
}


}