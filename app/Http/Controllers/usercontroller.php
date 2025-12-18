<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    private $data = [
        'Penyelenggara' => [
            'nama' => 'Dea Deswita',
            'email' => 'dea@penyelenggara.com',
            'foto' => 'default_penyelenggara.png',
            'role' => 'Penyelenggara',
        ],
        'Pengunjung' => [
            'nama' => 'Dea Pengunjung',
            'email' => 'dea@pengunjung.com',
            'foto' => 'default_pengunjung.png',
            'role' => 'Pengunjung',
        ],
    ];

    public function index(Request $request)
    {
        $role = $request->query('role', 'Pengunjung');
        if (!isset($this->data[$role])) {
            abort(404, 'Role tidak ditemukan');
        }
        $user = $this->data[$role];
        return view('profile', compact('user'));
    }

    public function edit(Request $request)
    {
        $role = $request->query('role', 'Pengunjung');
        if (!isset($this->data[$role])) {
            abort(404, 'Role tidak ditemukan');
        }
        $user = $this->data[$role];
        return view('edit', compact('user'));
    }

    public function update(Request $request)
    {
        $role = $request->input('role', 'Pengunjung');
        $user = $this->data[$role];

        $namaBaru = $request->input('nama');
        $fotoBaru = $user['foto'];

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFile = strtolower($role) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $namaFile);
            $fotoBaru = $namaFile;
        }

        // Update data sementara (tidak permanen)
        $user['nama'] = $namaBaru;
        $user['foto'] = $fotoBaru;

        // Kirim ke tampilan profile lagi
        return view('profile', compact('user'))->with('success', 'Profil berhasil diperbarui!');
    }

    public function logout()
    {
        return redirect('/');
    }
}