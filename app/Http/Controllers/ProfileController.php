<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Mapeamento estático: email do usuário → cidade (mesmo dos outros controllers)
    private $emailCityMap = [
        'teste@gmail.com' => 'Russas',
        // Adicione mais mapeamentos conforme necessário
    ];

    public function index()
    {
        $user = auth()->user();
        $userEmail = $user->email;
        
        // Verifica se o email do usuário está no mapeamento
        $city = $this->emailCityMap[$userEmail] ?? null;
        
        return view('profile', [
            'user' => $user,
            'city' => $city
        ]);
    }
}


