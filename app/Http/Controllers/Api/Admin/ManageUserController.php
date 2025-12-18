<?php


namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyelenggara;
use App\Models\Pengunjung;

class ManageUserController extends Controller
{
    public function index(){
        $penyelenggaras = Penyelenggara::all()->map(function ($user) {
            $user->role = 'Penyelenggara';
            return $user;
        });

        $pengunjungs = Pengunjung::all()->map(function ($user) {
            $user->role = 'Pengunjung';
            return $user;
        });

        $users = $penyelenggaras->merge($pengunjungs);

        return response()->json([
            'status' => true,
            'data' => $users
        ], 200);
    }

    public function destroy($id){
        $user = Penyelenggara::find($id) ?? Pengunjung::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User berhasil dihapus'
        ], 200);
    }

    public function toggleActive($role, $id)
    {
        $user = $role === 'penyelenggara'
            ? Penyelenggara::find($id)
            : Pengunjung::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'message' => 'Status user berhasil diubah',
            'is_active' => $user->is_active
        ], 200);
    }
}
