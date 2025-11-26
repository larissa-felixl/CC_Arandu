<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - {{ config('app.name') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <h1>Bem-vindo ao Dashboard, {{ Auth::user()->name }}!</h1>
        <p>Você está logado e visualizando informações {{ Auth::user()->city ? 'da cidade de ' . Auth::user()->city : 'de todas as cidades' }}</p>
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

    <div>
        <div class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md mb-8">
            <h3 class="text-lg text-gray-700 font-semibold mb-3 text-center">Top 10 Bairros com Mais Denúncias</h3>
            <canvas id="bairrosChart"></canvas>
        </div>
        <form method="GET" action="{{ route('dashboard') }}"
          class="flex gap-4 mb-6 bg-white p-4 rounded-xl shadow">

            <div>
                <label class="font-semibold text-gray-700">Ano:</label>
                <select name="ano" class="border p-2 rounded-lg">
                    <option value="todos">Todos</option>

                    @for ($i = 2024; $i <= now()->year; $i++)
                        <option value="{{ $i }}" {{ ($ano ?? '') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Mês:</label>
                <select name="mes" class="border p-2 rounded-lg">
                    <option value="todos">Todos</option>

                    @foreach ([1=>'Janeiro',2=>'Fevereiro',3=>'Março',
                            4=>'Abril',5=>'Maio',6=>'Junho',
                            7=>'Julho',8=>'Agosto',9=>'Setembro',
                            10=>'Outubro',11=>'Novembro',12=>'Dezembro'] as $num=>$nome)
                        <option value="{{ $num }}" {{ ($mes ?? '') == $num ? 'selected' : '' }}>
                            {{ $nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="bg-blue-600 text-white px-4 rounded-lg hover:bg-blue-700">Filtrar</button>
        </form>
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

<script>
    new Chart(document.getElementById('bairrosChart'), {
        type: 'bar',
        data: {
            labels: @json($labelsBairros),
            datasets: [{
                label: 'Denúncias',
                data: @json($valuesBairros),
                backgroundColor: ['#AF0303', '#C24B23', '#7B0F0F']
            }]
        }
    });
</script>
</body>
</html>
