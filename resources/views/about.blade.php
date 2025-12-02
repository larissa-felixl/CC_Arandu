<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - {{ config('app.name') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">  
</head>

<body class="bg-[#F6F6F6] text-gray-800 font-montserrat">

    <header class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logoAranduVermelha.png') }}" alt="Logo Arandu" class="h-10">
        </div>
        
        <nav class="flex items-center space-x-6 text-sm font-medium text-[#6C0D0E]">
            <a href="#" class="hover:text-[#983132]">GALERIA</a>
            <a href="{{ route('logout.page') }}" class="hover:text-[#983132]">LOGOUT</a>
            <a href="{{ route('dashboard') }}" class="hover:text-[#983132]">DASHBOARD</a>
            <a href="{{ route('about') }}" class="hover:text-[#983132]">SOBRE</a>
            <a href="{{ route('profile') }}" class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold hover:bg-gray-400">
            </a>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            <div class="flex flex-col gap-6">

                <div>
                    <p class="text-sm mb-2 text-[#46563B]">Fonte: Agência Brasil</p>
                    <img 
                        src="{{ asset('images/incendio1.png') }}" 
                        alt="Incêndio"
                        class="rounded-xl shadow-lg object-cover w-full h-64"
                    >
                </div>

                <div>
                    <p class="text-sm mb-2 text-[#46563B]">Fonte: O POVO+</p>
                    <img 
                        src="{{ asset('images/lixao1.png') }}" 
                        alt="Lixão"
                        class="rounded-xl shadow-lg object-cover w-full h-64"
                    >
                </div>

                <div class="mt-4">
                    <div class="flex flex-row items-start gap-2">
                        <img src="{{ asset('images/logo-padrao.png') }}" class="h-[100px]">
                        <p class="text-[30px] italic w-[400px] text-[#213D26]">
                            “Lembrar que por <strong>debaixo</strong>  
                            do <strong>concreto armado</strong>, existe  
                            o <strong>barro ancestral</strong>.”
                        </p>
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <img src="{{ asset('images/instagram.svg') }}" class="h-[50px]">
                        <span class="italic text-[20px] text-[#6C0D0E]" >@projarandu</span>
                        <img src="{{ asset('images/email.svg') }}" class="pl-[10px] h-[50px]">
                        <span class="italic text-[20px] text-[#6C0D0E]"> aranduproject@gmail.com</span>
                        
                    </div>
                </div>

            </div>

            <div class="bg-[#629956] text-white p-8 rounded-xl shadow-xl">

                <h1 class="text-4xl font-bold mb-6 text-center">
                    QUEM SOMOS?
                </h1>

                <div class="leading-7 text-base text-justify space-y-4">
                    <p>
                        Somos uma equipe de estudantes do curso técnico em Desenvolvimento 
                        de Sistemas da EEEP Jeová Costa Lima, movidas pela paixão por tecnologia 
                        e inovação. Nosso projeto surgiu com o propósito de auxiliar na coleta e 
                        organização de dados sobre duas problemáticas que impactam diretamente 
                        o meio ambiente: os focos de lixo viciado e as queimadas.
                    </p>
                    
                    <p>
                        A ideia nasceu a partir do LabGirlsTech, nosso outro projeto, que tem 
                        como objetivo incentivar a presença feminina na área da Tecnologia da 
                        Informação (TI). Inspiradas por essa iniciativa, decidimos unir nossos 
                        conhecimentos para criar uma aplicação funcional capaz de apoiar órgãos 
                        públicos no monitoramento e controle dessas ocorrências em toda a região.
                    </p>
                    
                    <p>
                        Assim surgiu o Arandu, um projeto desenvolvido coletivamente após uma 
                        análise detalhada dos dados de queimadas e acúmulo de lixo na cidade de 
                        Russas. A partir desse estudo, estruturamos nossa proposta e iniciamos a 
                        criação dos protótipos do aplicativo. Durante o processo, registramos 
                        todas as reuniões e etapas de desenvolvimento em nosso caderno de campo.
                    </p>
                    
                    <p>
                        A programação do app foi realizada na plataforma no-code FlutterFlow, 
                        utilizando o banco de dados Supabase. Após a conclusão do aplicativo 
                        e a vitória na etapa regional do Ceará Científico 2025, expandimos o 
                        projeto com o desenvolvimento de um sistema web para visualização dos 
                        dados coletados, vindos do App. Essa etapa também marcou o início de 
                        uma parceria com um órgão público ambiental, interessado em utilizar 
                        as informações geradas pela aplicação para fortalecer suas ações.
                    </p>
                </div>
            </div>

        </section>
    </main>
</body>
</html>