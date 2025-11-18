<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Focos de Lixo - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .header {
            background-color: #FF9800;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .back-button:hover {
            background-color: #45a049;
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
        .badge-type {
            background-color: #FF9800;
            color: white;
        }
        .badge-city {
            background-color: #2196F3;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <ul>
            <li><a href="#">Galeria</a></li>
            <li><a href="{{ route('logout') }}">Logout</a></li>
            <li><a href="{{ route('dashboard.page') }}">Dashboard</a></li>
            <li><a href="#">sobre</a></li>
            <li><a href="{{ route('profile') }}">perfil</a></li>
        </ul>
    </header>
    <div class="header">
        <h1>Focos de Lixo</h1>
        <p>Visualizando relatórios de focos de lixo {{ $city ? 'da cidade de ' . $city : 'de todas as cidades' }}</p>
    </div>

    <a href="{{ route('dashboard') }}" class="back-button">← Voltar ao Dashboard</a>

    <div class="reports-container">
        <h2>Relatórios de Lixo {{ $city ? 'de ' . $city : '' }}</h2>
        
        @if($reports->count() > 0)
            @foreach($reports as $report)
                <div class="report-item">
                    <p><strong>Tipo:</strong> <span class="badge badge-type">{{ $report->type->name ?? 'N/A' }}</span></p>
                    <p><strong>Cidade:</strong> <span class="badge badge-city">{{ $report->city }}</span></p>
                    <p><strong>Bairro:</strong> {{ $report->neighborhood }}</p>
                    <p><strong>Endereço:</strong> {{ $report->address }}</p>
                    @if($report->obs)
                        <p><strong>Observações:</strong> {{ $report->obs }}</p>
                    @endif
                    <p><strong>Data:</strong> {{ $report->created_at->format('d/m/Y H:i') }}</p>
                </div>
            @endforeach
        @else
            <p style="color: #999; text-align: center; padding: 20px;">
                Nenhum relatório de lixo encontrado{{ $city ? ' para a cidade de ' . $city : '' }}.
            </p>
        @endif
    </div>
</body>
</html>