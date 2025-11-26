<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Focos de queimada - {{ config('app.name') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    
    <div style="background-color: antiquewhite;">
        <h2>Total de Denúncias de Queimada</h2>
        <p>{{ $reports->count() }}</p>
    </div>

    @if($peakMonth)
    <div style="background-color: bisque;">
        <h2> Mês com Mais Denúncias de Queimada</h2>
        <p>{{ $peakMonth['name'] }}</p>
        <p>Total de {{ $peakMonth['total'] }} denúncias</p>
    </div>
    @endif

    @if($leastMonth)
    <div style="background-color: #d4edda;">
        <h2>📉 Mês com Menos Denúncias de Queimada</h2>
        <p>{{ $leastMonth['name'] }}</p>
        <p>Total de {{ $leastMonth['total'] }} denúncias</p>
    </div>
    @endif

    <div>
        <div class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md">
        <h3 class="text-lg text-gray-700 font-semibold mb-3 text-center">Níveis de Fogo</h3>
        <canvas id="tiposChart"></canvas>
    </div>
    </div>

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
                        <td>{{ $report->fireLevel ? $report->fireLevel->level_name : 'N/A' }}</td>
                        <td>{{ $report->created_at->format('d/m/Y') }}</td>
                        <td>{{ $report->created_at->format('H:i') }}</td>
                        <!-- <td><img src="{{ $report->img }}" alt=""></td> -->
                        <td>
                            @if($report->img)
                                <img src="{{ $report->img }}" alt="Foto do relatório" width="100">
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

<script>
    const labelsTipos = @json($labelsTipos);
    const valuesTipos = @json($valuesTipos);
    const nomesTipos = {
        1: "Focos baixos",
        2: "Focos Médios",
        3: "Focos Grandes",
        4: "Focos Preocupantes"
    };

    new Chart(document.getElementById('tiposChart'), {
        type: 'doughnut',
        data: {
            labels: labelsTipos.map(n => nomesTipos[n]),
            datasets: [{
                data: valuesTipos,
                backgroundColor: [
                    '#6C0E0E', '#A45007', '#C3AE83',
                    '#935139'
                ]
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            const total = ctx.chart._metasets[0].total;
                            const value = ctx.raw;
                            const pct = ((value / total) * 100).toFixed(1);
                            return `${value} denúncias (${pct}%)`;
                        }
                    }
                }
            }
        }
    });
</script>
</body>
</html>