<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class FireController extends Controller
{
    // Mapeamento estático: email do usuário → cidade (mesmo do DashboardController)
    private $emailCityMap = [
        'teste@gmail.com' => 'Russas',
        // Adicione mais mapeamentos conforme necessário
    ];

    public function index()
    {
        $user = Auth::user();
        $userEmail = $user->email;
        
        // Verifica se o email do usuário está no mapeamento
        $city = $this->emailCityMap[$userEmail] ?? null;
        
        // Filtra reports do tipo fogo/queimada (reports_type_id = 1)
        $query = Report::with(['type', 'user'])
            ->where('reports_type_id', 1);
        
        // Se houver cidade mapeada, filtra também por cidade
        if ($city) {
            $query->where('city', $city);
        }
        
        $reports = $query->orderBy('created_at', 'desc')->get();
        
        return view('fire', [
            'user' => $user,
            'city' => $city,
            'reports' => $reports
        ]);
    }
}