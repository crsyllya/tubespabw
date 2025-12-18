@extends('layout.app')

@section('content')

<div style="width:350px; margin:auto; border:1px solid #ddd; padding:25px; border-radius:8px; margin-top:40px; font-family:Arial;">

    <h2 style="text-align:center">Register</h2>

    <!-- Tampilkan error -->
    @if($errors->any())
        <div style="color:red; margin-bottom:10px; padding:10px; border:1px solid red; border-radius:5px;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if(session('success'))
        <p style="color:green; margin-bottom:10px;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('register.process') }}" method="POST">
        @csrf

        <label>Nama Lengkap *</label>
        <input type="text" name="name" value="{{ old('name') }}" required
               style="width:100%; padding:8px; margin:8px 0;">

        <label>Email *</label>
        <input type="email" name="email" value="{{ old('email') }}" required
               style="width:100%; padding:8px; margin:8px 0;">

        <label>Password *</label>
        <input type="password" name="password" required
               style="width:100%; padding:8px; margin:8px 0;"
               placeholder="Minimal 6 karakter">

        <label>Konfirmasi Password *</label>
        <input type="password" name="password_confirmation" required
               style="width:100%; padding:8px; margin:8px 0;"
               placeholder="Ketik ulang password">

        <label>Daftar Sebagai *</label>
        <select name="role" required
                style="width:100%; padding:8px; margin:8px 0;">
            <option value="">-- Pilih Role --</option>
            <option value="penyelenggara" {{ old('role') == 'penyelenggara' ? 'selected' : '' }}>Penyelenggara</option>
            <option value="pengunjung" {{ old('role') == 'pengunjung' ? 'selected' : '' }}>Pengunjung</option>
        </select>

        <button type="submit"
                 style="width:100%; padding:10px; background:#3b82f6; color:white; border:none; margin-top:10px;">
            Regist
        </button>

    </form>

    <div style="text-align:center; margin-top:15px;">
        <p>Sudah punya akun? <a href="{{ route('auth.login') }}">Login di sini</a></p>
    </div>

</div>

@endsection