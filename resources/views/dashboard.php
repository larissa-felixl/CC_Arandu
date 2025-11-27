<!DOCTYPE html>
  <html lang="pt-BR">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
      <title>Dashboard Arandu</title>


    </head>

    <body class="bg-[#F6F6F6] text-gray-800 font-montserrat">

      <header class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <div class="flex items-center space-x-2">
          <img src="{{ asset('asset/images/Asset5.png') }}" class="h-10">

        </div>
        
        <nav class="flex items-center space-x-6 text-sm font-medium text-[#6C0D0E]">
          <a href="#" class="hover:text-[#983132]">GALERIA</a>
          <a href="#" class="hover:text-[#983132]">LOGOUT</a>
          <a href="#" class="hover:text-[#983132]">DASHBOARD</a>
          <a href="#" class="hover:text-[#983132]">SOBRE</a>
          <div class="w-10 h-10 rounded-full bg-gray-300"></div>
        </nav>

      </header>

<div class="w-full flex justify-center py-10 px-4 bg-[#F6F6F6]">
  
  <div class="w-full max-w-5xl bg-white shadow-lg rounded-xl border border-gray-200 p-8">


    <div class="flex flex-col md:flex-row gap-10">

 
      <div class="flex flex-col items-center">
        <img 
          src="{{ asset('images/perfil.png') }}" 
          class="w-60 h-60 rounded-full object-cover shadow-md"
        >

        <button class="mt-4 bg-[#6C0D0E] hover:bg-[#983132] text-white px-4 py-2 rounded-full flex items-center gap-2">
          <span class="text-white">⤓</span>
          Editar imagem
        </button>
      </div>

      <div class="grid grid-cols-1 gap-4 w-full">

        <div>
          <h3 class="text-xs font-semibold text-gray-500">NOME:</h3>
          <p class="bg-gray-100 px-3 py-2 rounded-md">Fulana da Silva</p>
        </div>

        <div>
          <h3 class="text-xs font-semibold text-gray-500">CARGO:</h3>
          <p class="bg-gray-100 px-3 py-2 rounded-md">Secretária</p>
        </div>

        <div>
          <h3 class="text-xs font-semibold text-gray-500">TELEFONE:</h3>
          <p class="bg-gray-100 px-3 py-2 rounded-md">88 12345678</p>
        </div>

        <div>
          <h3 class="text-xs font-semibold text-gray-500">E-MAIL:</h3>
          <p class="bg-gray-100 px-3 py-2 rounded-md">sema@gmail.com</p>
        </div>

        <div>
          <h3 class="text-xs font-semibold text-gray-500">CIDADE:</h3>
          <p class="bg-gray-100 px-3 py-2 rounded-md">Russas</p>
        </div>

      </div>

    </div>

    <div class="mt-10">
      <h3 class="text-xs font-semibold text-gray-700 mb-1">INSTITUIÇÃO:</h3>
      <p class="bg-[#6C0D0E] text-white px-4 py-3 rounded-md font-semibold">
        SECRE. DO MEIO AMBIENTE DE RUSSAS
      </p>
    </div>

  </div>

</div>
