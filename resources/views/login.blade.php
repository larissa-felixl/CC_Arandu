<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Arandu</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen flex bg-gray-100 font-montserrat">

    <div 
        class="hidden lg:flex flex-col justify-between w-1/2 bg-cover bg-center text-white p-10"
        style="background-image: url('{{ asset('images/banner-arandu.png') }}');"
    >
        <div class="mt-10">
            <p class="italic text-sm leading-relaxed text-[#f5e7d0] drop-shadow-md">
                Protegendo o <span class="font-bold">meio ambiente</span> hoje <br>
                para <span class="font-semibold">garantir</span> resultados no futuro.
            </p>
        </div>

        <div class="flex items-center space-x-2 mb-8">
            <h1 class="text-4xl font-semibold tracking-widest text-[#f5e7d0]">ARANDU</h1>
        </div>
    </div>

    <div class="flex flex-col justify-center items-center w-full lg:w-1/2 px-8">
        <h2 class="text-2xl font-bold text-[#7b3f1c] underline mb-6">LOGIN</h2>

        <form method="POST" action="{{ route('login.post') }}" class="bg-white shadow-md rounded-lg p-8 w-full max-w-sm">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-[#7b3f1c] font-semibold mb-1">E-mail</label>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    required 
                    autofocus
                    class="w-full border-2 border-[#7b3f1c] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#7b3f1c]"
                    placeholder="Digite seu e-mail"
                >
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-[#7b3f1c] font-semibold mb-1">Senha</label>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    required
                    class="w-full border-2 border-[#7b3f1c] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#7b3f1c]"
                    placeholder="Digite sua senha"
                >
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button 
                type="submit" 
                class="w-full bg-[#7b3f1c] hover:bg-[#5d2f15] text-white font-bold py-2 px-4 rounded-md transition-colors duration-300"
            >
                Entrar
            </button>
        </form>
    </div>
    
</body>
</html>
