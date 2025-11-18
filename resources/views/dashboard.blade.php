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
            <li><a href="#">Galeria</a></li>
            <li><a href="{{ route('logout.page') }}">Logout</a></li>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="#">sobre</a></li>
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
    

    <div class="user-info">
        <h3>Informações do Perfil</h3>
        <p><strong>Nome:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Cidade atribuída:</strong> 
            @if($city)
                <span class="badge badge-city">{{ $city }}</span>
            @else
                <span style="color: #999;">Nenhuma cidade específica (acesso completo)</span>
            @endif
        </p>
    </div>

    <div class="reports-container">
        <h2>Relatórios {{ $city ? 'de ' . $city : 'de todas as cidades' }}</h2>
        
        @if($reports->count() > 0)
            @foreach($reports as $report)
                <div class="report-item">
                    <p><strong>Tipo:</strong> <span class="badge badge-type">{{ $report->type->name ?? 'N/A' }}</span></p>
                    <p><strong>Cidade:</strong> {{ $report->city }}</p>
                    <p><strong>Bairro:</strong> {{ $report->neighborhood }}</p>
                    <p><strong>Endereço:</strong> {{ $report->address }}</p>
                    @if($report->obs)
                        <p><strong>Observações:</strong> {{ $report->obs }}</p>
                    @endif
                    <p><strong>Data:</strong> {{ $report->created_at->format('d/m/Y H:i') }}</p>
                    @if($report->fireLevel)
                        <p><strong>Nível de Fogo:</strong> {{ $report->fireLevel->level ?? 'N/A' }}</p>
                    @endif
                </div>
            @endforeach
        @else
            <p style="color: #999; text-align: center; padding: 20px;">
                Nenhum relatório encontrado{{ $city ? ' para a cidade de ' . $city : '' }}.
            </p>
        @endif
    </div>

    <div style="margin-top: 20px;">
        <a href="{{ route('logout.page') }}" style="display: inline-block; padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px; cursor: pointer;">
            Sair
        </a>
    </div>
</body>
</html>
