<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de usuário - {{ config('app.name') }}</title>
</head>
<body>
    <header>
        <ul>
            <li><a href="#">Galeria</a></li>
            <li><a href="{{ route('logout') }}">Logout</a></li>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('about') }}">sobre</a></li>
            <li><a href="{{ route('profile') }}">perfil</a></li>
        </ul>
    </header>
    <div>
        <div style="color:red brown"></div>
        <div>
            <h1>Perfil de {{ $user->name }}</h1>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Cidade atribuída:</strong> 
                @if($city)
                    <span style="color: #2196F3; font-weight: bold;">{{ $city }}</span>
                @else
                    <span style="color: #999;">Nenhuma cidade específica (acesso completo)</span>
                @endif
            </p>
            <p><strong>Nível de acesso:</strong> Visualizar relátorios</p>
            <p><strong>Registrado em:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
        </div>
    </div>

</body>
</html>