<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class DashboardController extends Controller
{
    // Mapeamento estático: email do usuário → cidade
    private $emailCityMap = [
        'teste@gmail.com' => 'Russas',
        // Adicione mais mapeamentos conforme necessário:
        // 'outro@gmail.com' => 'Fortaleza',
        // 'usuario@gmail.com' => 'Limoeiro do Norte',
    ];

    public function index()
    {
        $user = Auth::user();
        $userEmail = $user->email;
        
        // Verifica se o email do usuário está no mapeamento
        $city = $this->emailCityMap[$userEmail] ?? null;
        
        // Se houver cidade mapeada, filtra os reports por essa cidade
        if ($city) {
            $reports = Report::where('city', $city)
                ->with(['type', 'user', 'fireLevel'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Se não houver mapeamento, mostra todos (admin ou usuário sem cidade)
            $reports = Report::with(['type', 'user', 'fireLevel'])
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('dashboard', [
            'user' => $user,
            'city' => $city,
            'reports' => $reports
        ]);
    }

}
