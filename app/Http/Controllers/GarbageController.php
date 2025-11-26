<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class GarbageController extends Controller
{
    // Mapeamento estático: email do usuário → cidade (mesmo do DashboardController)
    private $emailCityMap = [
        'teste@gmail.com' => 'Fortaleza',
        // Adicione mais mapeamentos conforme necessário
    ];

    public function index()
    {
        $user = Auth::user();
        $userEmail = $user->email;
        
        // Verifica se o email do usuário está no mapeamento
        $city = $this->emailCityMap[$userEmail] ?? null;
        
        // Filtra reports do tipo lixo (reports_type_id = 2)
        $query = Report::with(['type', 'user'])
            ->where('reports_type_id', 2);
        
        // Se houver cidade mapeada, filtra também por cidade
        if ($city) {
            $query->where('city', $city);
        }
        
        $reports = $query->orderBy('created_at', 'desc')->get();
        
        // Calcula estatísticas por mês - Mês com MAIS denúncias
        $statsQuery = Report::where('reports_type_id', 2);
        if ($city) {
            $statsQuery->where('city', $city);
        }
        
        $reportsByMonth = $statsQuery->selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('total', 'desc')
            ->first();

        // Calcula estatísticas por mês - Mês com MENOS denúncias
        $statsQueryLeast = Report::where('reports_type_id', 2);
        if ($city) {
            $statsQueryLeast->where('city', $city);
        }
        
        $reportsByLeastMonth = $statsQueryLeast->selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('total', 'asc')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
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
        
        // Formata o mês com menos denúncias
        $leastMonth = null;
        if ($reportsByLeastMonth) {
            $monthNames = [
                1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
            ];
            $leastMonth = [
                'name' => $monthNames[$reportsByLeastMonth->month] . '/' . $reportsByLeastMonth->year,
                'total' => $reportsByLeastMonth->total
            ];
        }
        
        return view('garbage', [
            'user' => $user,
            'city' => $city,
            'reports' => $reports,
            'peakMonth' => $peakMonth,
            'leastMonth' => $leastMonth
        ]);
    }
}
