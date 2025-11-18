<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Focos de queimada - {{ config('app.name') }}</title>
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
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('about') }}">sobre</a></li>
            <li><a href="{{ route('profile') }}">perfil</a></li>
        </ul>
    </header>
    <div class="header">
        <h1>Focos de Queimada</h1>
        <p>Visualizando relatórios de focos de queimada {{ $city ? 'da cidade de ' . $city : 'de todas as cidades' }}</p>
    </div>

    <a href="{{ route('dashboard') }}" class="back-button">← Voltar ao Dashboard</a>

        <h2>Relatórios de Queimada {{ $city ? 'de ' . $city : '' }}</h2>    
        <table border="2">
            <thead>
                <tr>
                    <th>endereço</th>
                    <th>descrição</th>
                    <th>nível</th>
                    <th>data</th>
                    <th>hora</th>
                    <th>foto</th>
                </tr>
            </thead>
            <tbody>
                @if ($reports->count() > 0)
                    @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->address }}</td>
                        <td>{{ $report->obs }}</td>
                        <td>{{ $report->fireLevel->level ?? 'N/A' }}</td>
                        <td>{{ $report->created_at->format('d/m/Y') }}</td>
                        <td>{{ $report->created_at->format('H:i') }}</td>
                        <td>
                            @if($report->photo_url)
                                <img src="{{ $report->photo_url }}" alt="Foto do relatório" width="100">
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" style="text-align: center; color: #999; padding: 20px;">
                            Nenhum relatório de queimada encontrado{{ $city ? ' para a cidade de ' . $city : '' }}.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
</body>
</html>