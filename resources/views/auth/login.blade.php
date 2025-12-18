@extends('layout.app')

@section('content')

<div style="width:350px; margin:auto; border:1px solid #ddd; padding:25px; border-radius:8px; margin-top:40px; font-family:Arial;">

    <h2 style="text-align:center">Login</h2>

    @if($errors->any())
        <p style="color:red; margin-bottom:10px;">{{ $errors->first() }}</p>
    @endif

    <form action="{{ route('login.process') }}" method="POST">
        @csrf

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required
               style="width:100%; padding:8px; margin:8px 0;">

        <label>Password</label>
        <input type="password" name="password" required
               style="width:100%; padding:8px; margin:8px 0;">

        <button type="submit"
                style="width:100%; padding:10px; background:#3b82f6; color:white; border:none; margin-top:10px;">
            Login
        </button>

    </form>

    <div style="text-align:center; margin-top:15px;">
        <p>Belum punya akun? <a href="{{ route('auth.register') }}">Daftar di sini</a></p>
    </div>

</div>

@endsection