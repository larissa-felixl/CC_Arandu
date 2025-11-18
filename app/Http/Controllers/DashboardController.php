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
        
        // Query base para reports
        $reportsQuery = Report::with(['type', 'user', 'fireLevel']);
        
        // Se houver cidade mapeada, filtra os reports por essa cidade
        if ($city) {
            $reportsQuery->where('city', $city);
        }
        
        // Pega todos os reports
        $reports = $reportsQuery->orderBy('created_at', 'desc')->get();
        
        // Calcula estatísticas por mês (nova query)
        $statsQuery = Report::query();
        if ($city) {
            $statsQuery->where('city', $city);
        }
        
        $reportsByMonth = $statsQuery->selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('total', 'desc')
            ->first();
        
        // Formata o mês com mais denúncias
        $peakMonth = null;
        if ($reportsByMonth) {
            $monthNames = [
                1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
            ];
            $peakMonth = [
                'name' => $monthNames[$reportsByMonth->month] . '/' . $reportsByMonth->year,
                'total' => $reportsByMonth->total
            ];
        }
        
        return view('dashboard', [
            'user' => $user,
            'city' => $city,
            'reports' => $reports,
            'peakMonth' => $peakMonth
        ]);
    }

}
