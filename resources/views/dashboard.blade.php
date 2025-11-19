<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .user-info {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .reports-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .report-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        .report-item:last-child {
            border-bottom: none;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-city {
            background-color: #2196F3;
            color: white;
        }
        .badge-type {
            background-color: #FF9800;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <ul>
            <li><a href="{{ route('logout.page') }}">Logout</a></li>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('about') }}">sobre</a></li>
            <li><a href="{{ route('profile') }}">perfil</a></li>
        </ul>
    </header>

    <div class="header">
        <h1>Bem-vindo ao Dashboard, {{ $user->name }}!</h1>
        <p>Você está logado e visualizando informações {{ $city ? 'da cidade de ' . $city : 'de todas as cidades' }}</p>
    </div>
    <div>
        <h1>Acesse todos os dados de </h1>
        <button type="button"><a href="{{ route('garbage') }}">focos de lixo</a></button>
        <button type="button"><a href="{{ route('fire') }}">focos de queimada</a></button>
    </div>

    <div>
        <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam similique voluptatem ipsa vitae accusantium quam mollitia repellat ex, asperiores tenetur, neque rem saepe eum iste velit magni placeat? Necessitatibus, illum!</span>
    </div>

    <div>
        <h1 style="background-color: #d4edda;">Incidencias </h1>
        <span>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fuga, cupiditate magni, ea error porro ut amet veritatis nostrum aliquid eligendi quidem sint dolore. Possimus animi eum sequi, unde deserunt ea.
        </span>
    </div>

    <div style="background-color: antiquewhite;">
        <h1>total de denúncias</h1>
        <p>{{ $reports->count() }}</p>
    </div>

    @if($peakMonth)
    <div style="background-color: bisque ">
        <h2 >Mês com Mais Denúncias</h2>
        <p>{{ $peakMonth['name'] }}</p>
        <p>Total de {{ $peakMonth['total'] }} denúncias</p>
    </div>
    @endif

    @if($leastMonth)
    <div style="background-color: #d4edda; ">
        <h2 >Mês com Menos Denúncias</h2>
        <p >{{ $leastMonth['name'] }}</p>
        <p>Total de {{ $leastMonth['total'] }} denúncias</p>
    </div>
    @endif

    <div style="margin-top: 20px;">
        <a href="{{ route('logout.page') }}" style="display: inline-block; padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px; cursor: pointer;">
            Sair
        </a>
    </div>
</body>
</html>
