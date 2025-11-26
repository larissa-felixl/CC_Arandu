<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Arandu - {{ config('app.name') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">    
</head>

<body class="bg-[#F6F6F6] text-gray-800 font-montserrat">

    <header class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logoAranduVermelha.png') }}" alt="Logo Arandu vermelha" class="h-10">
        </div>
        
        <nav class="flex items-center space-x-6 text-sm font-medium text-[#6C0D0E]">
            <a href="#" class="hover:text-[#983132]">GALERIA</a>
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
                    Bem-vindo, {{ $user->name }}!
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
                <h2 class="text-center text-[20px] font-bold uppercase text-[#6C0D0E] mb-4">
                    10 Bairros com mais denúncias no município
                </h2>
                <!-- Simulação de gráfico -->
                <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center p-4">
                    <p class="text-gray-500 text-center">Gráfico em desenvolvimento</p>
                </div>
            </div>

            <div class="flex justify-between">
                <button class="bg-[#86391F] hover:bg-[#A45006] text-white font-semibold px-8 py-1 rounded-[5px] w-[48%]">
                    MENSAL
                </button>
                <button class="bg-[#86391F] hover:bg-[#A45006] text-white font-semibold px-8 py-1 rounded-[5px] w-[48%]">
                    ANUAL
                </button>
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
                        onclick="alert('Aqui você pode adicionar informações sobre as incidências de queimadas e focos de lixo.')"
                    >
                        ?
                    </button>
                </div>

                <div class="flex justify-center items-center">
                    <div class="relative w-24 h-24 rounded-full border-8 border-red-700">
                        <div class="absolute inset-[10px] bg-white rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold">70%</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-3 space-x-4 text-xs">
                    <div class="flex items-center space-x-1">
                        <span class="w-3 h-3 bg-orange-400 rounded"></span>
                        <span>Focos de Lixo</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="w-3 h-3 bg-red-700 rounded"></span>
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

</body>
</html>
