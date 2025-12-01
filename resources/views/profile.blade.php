<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - {{ config('app.name') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#F6F6F6] text-gray-800 font-montserrat">

    <!-- HEADER -->
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

    <!-- CONTAINER PRINCIPAL -->
    <div class="max-w-6xl mx-auto bg-white shadow-xl rounded-xl mt-6 overflow-visible">

        <div class="relative bg-[#681616] text-white p-6 rounded-t-xl flex items-center justify-between">
            <h1 class="text-xl font-bold w-[60%] leading-6">
                INSTITUIÇÃO: SECRETARIA DO MEIO AMBIENTE
            </h1>
        </div>

        <!-- CONTEÚDO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 p-6 pb-12 relative">

            <!-- COLUNA ESQUERDA -->
            <div class="flex flex-col gap-4 mt-20 mb-8">

                <div class="bg-[#E8E2DF] px-4 py-3 rounded-md font-bold text-[#681616]">
                    NOME: <span class="font-bold text-[#681616]">{{ $user->name }}</span>
                </div>

                <div class="bg-[#E8E2DF] px-4 py-3 rounded-md font-bold text-[#681616]">
                    CARGO: <span class="font-bold text-[#681616]">Gestor(a)</span>
                </div>

                <div class="bg-[#E8E2DF] px-4 py-3 rounded-md font-bold text-[#681616]">
                    E-MAIL: <span class="font-bold text-[#681616]">{{ $user->email }}</span>
                </div>

                <div class="bg-[#E8E2DF] px-4 py-3 rounded-md font-bold text-[#681616]">
                    CIDADE: <span class="font-bold text-[#681616]">{{ $city ?? 'Todas' }}</span>
                </div>

                <div class="bg-[#E8E2DF] px-4 py-3 rounded-md font-bold text-[#681616]">
                    REGISTRADO EM: <span class="font-bold text-[#681616]">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>

            </div>

            <!-- COLUNA DIREITA -->
            <div class="flex flex-col items-center mt-10 relative z-10">

                <div class="w-[450px] h-[450px] bg-white rounded-full overflow-hidden shadow-lg border-[6px] border-white -mt-44">
                    <div class="w-full h-full flex items-center justify-center bg-gray-300 text-white text-9xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>

                <span class="mt-6 text-4xl font-bold text-[#681616] bg-[#EBC6C6] px-14 py-3 rounded-lg shadow">
                    {{ explode(' ', $user->name)[0] }}
                </span>
            </div>

        </div>

    </div>

</body>
</html>