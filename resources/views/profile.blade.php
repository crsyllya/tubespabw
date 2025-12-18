<!DOCTYPE html>
<html>
<head>
    <title>Profil Pengguna</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        .container {
            display: flex;
            align-items: flex-start;
            gap: 30px;
        }
        img {
            width: 120px;
            height: auto;
            border-radius: 4px;
        }
        a { display: block; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Profil Pengguna</h1>

    <div class="container">
        <div>
            @if(!empty($user['foto']))
                <img src="{{ asset('uploads/' . $user['foto']) }}" alt="Foto Profil">
            @endif
        </div>

        <div>
            <p><strong>Nama:</strong> {{ $user['nama'] }}</p>
            <p><strong>Email:</strong> {{ $user['email'] }}</p>

            <a href="{{ route('profile.edit', ['role' => $user['role']]) }}">Edit Profil</a>

            <a href="{{ $user['role'] == 'Penyelenggara' ? route('dashboard.penyelenggara') : route('dashboard.pengunjung') }}">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>