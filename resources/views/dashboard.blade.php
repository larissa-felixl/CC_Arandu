<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Arandu - {{ config('app.name') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">  
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  
</head>

<body class="bg-[#F6F6F6] text-gray-800 font-montserrat">

    <header class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logoAranduVermelha.png') }}" alt="Logo Arandu vermelha" class="h-10">
        </div>
        
        <nav class="flex items-center space-x-6 text-sm font-medium text-[#6C0D0E]">
            <a href="{{ route('logout.page') }}" class="hover:text-[#983132]">LOGOUT</a>
            <a href="{{ route('dashboard') }}" class="hover:text-[#983132]">DASHBOARD</a>
            <a href="{{ route('about') }}" class="hover:text-[#983132]">SOBRE</a>
            <a href="{{ route('profile') }}" class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold hover:bg-gray-400">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </a>
        </nav>
    </header>

    <!-- Main -->
    <main class="p-8 grid grid-cols-3 gap-6">
        
        <!-- Coluna esquerda -->
        <section class="col-span-2 space-y-6">

            <!-- Bem-vindo e cidade -->
            <div class="bg-white rounded-xl shadow p-4">
                <h1 class="text-[24px] font-bold text-[#6C0D0E] mb-2">
                    Bem-vindo(a), {{ $user->name }}!
                </h1>
                <p class="text-gray-600">
                    Você está visualizando informações {{ $city ? 'da cidade de ' . $city : 'de todas as cidades' }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-4 text-center">
                <p class="text-[20px] font-bold uppercase text-[#6C0D0E] mb-3">
                    Acesse todos os dados de
                </p>
                <div class="flex justify-center space-x-6">
                    <a href="{{ route('fire') }}" class="bg-[#6C0D0E] hover:bg-[#983132] text-white text-[22px] font-bold px-12 py-2 w-1/2 rounded-[5px] text-center">
                        QUEIMADAS
                    </a>
                    <a href="{{ route('garbage') }}" class="bg-[#6C0D0E] hover:bg-[#983132] text-white text-[22px] font-bold px-12 py-2 w-1/2 rounded-[5px] text-center">
                        FOCOS DE LIXO
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-center text-[20px] font-bold uppercase text-[#4A5568] mb-6">
                    Top 10 Bairros com Mais Denúncias
                </h2>

                <div class="w-full mb-6">
                    <canvas id="bairrosChart" style="max-height: 400px;"></canvas>
                </div>

                <form method="GET" action="{{ route('dashboard') }}"
                    class="flex flex-col gap-4 bg-white p-4 rounded-xl">

                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label class="font-semibold text-gray-700 block mb-2">Ano:</label>
                                <select name="ano" class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:border-[#86391F]">
                                    <option value="todos">Todos</option>

                                    @for ($i = 2024; $i <= now()->year; $i++)
                                        <option value="{{ $i }}" {{ ($ano ?? '') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="flex-1">
                                <label class="font-semibold text-gray-700 block mb-2">Mês:</label>
                                <select name="mes" class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:border-[#86391F]">
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
                        </div>

                        <button type="submit" class="bg-[#86391F] hover:bg-[#A45006] text-white font-bold px-8 py-3 rounded-[5px] w-full uppercase">
                            Filtrar
                        </button>
                </form>
            </div>

        </section>

        <!-- Coluna direita -->
        <aside class="space-y-6">

            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-[20px] text-[#6C0D0E] uppercase">Incidências</h3>
                    <button
                        class="flex items-center justify-center w-8 h-8 rounded-full bg-[#6C0D0E] text-white text-lg font-bold 
                                hover:bg-[#983132] transition-colors duration-300"
                        title="Mais informações sobre as incidências"
                        onclick="alert('Este gráfico mostra a porcentagem de denúncias de queimadas e focos de lixo registradas no município.')"
                    >
                        ?
                    </button>
                </div>

                <div class="flex justify-center items-center my-4">
                    <canvas id="incidenciasChart" style="max-height: 200px; max-width: 200px;"></canvas>
                </div>

                <div class="flex justify-center mt-3 space-x-4 text-xs">
                    <div class="flex items-center space-x-1">
                        <span class="w-3 h-3 bg-[#C24B23] rounded"></span>
                        <span>Focos de Lixo</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="w-3 h-3 bg-[#AF0303] rounded"></span>
                        <span>Queimadas</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-4">
                <h3 class="text-[20px] font-bold text-sm text-[#6C0D0E] uppercase">Total de denúncias</h3>
                <p class="text-3xl font-bold text-center text-amber-600 mt-2">{{ $reports->count() }}</p>
            </div>

            @if($peakMonth)
            <div class="bg-white rounded-xl shadow p-4">
                <h3 class="text-[20px] font-bold text-sm text-[#6C0D0E] uppercase">Mês com mais denúncias</h3>
                <p class="text-center font-bold text-amber-600 mt-2 text-xl">{{ $peakMonth['name'] }}</p>
                <p class="text-center text-gray-600 text-sm">{{ $peakMonth['total'] }} denúncias</p>
            </div>
            @endif

            @if($leastMonth)
            <div class="bg-white rounded-xl shadow p-4">
                <h3 class="text-[20px] font-bold text-sm text-[#6C0D0E] uppercase">Mês com menos denúncias</h3>
                <p class="text-center font-bold text-amber-600 mt-2 text-xl">{{ $leastMonth['name'] }}</p>
                <p class="text-center text-gray-600 text-sm">{{ $leastMonth['total'] }} denúncias</p>
            </div>
            @endif

        </aside>
    </main>
    <script>
    // Gráfico de Incidências (Doughnut)
    new Chart(document.getElementById('incidenciasChart'), {
        type: 'doughnut',
        data: {
            labels: @json($typeName),
            datasets: [{
                label: '% de Denúncias',
                data: @json($percentuals),
                backgroundColor: ['#AF0303', '#C24B23'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            }
        }
    });

    // Gráfico de Bairros (Bar)
    new Chart(document.getElementById('bairrosChart'), {
        type: 'bar',
        data: {
            labels: @json($labelsBairros),
            datasets: [{
                label: 'Quantidade de denúncias',
                data: @json($valuesBairros),
                backgroundColor: ['#AF0303', '#C24B23', '#7B0F0F']
            }]
        }
    });
</script>

</body>
</html>
