<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Report;

class FireController extends Controller
{
    // Mapeamento estático: email do usuário → cidade (mesmo do DashboardController)
    private $emailCityMap = [
        'teste@gmail.com' => 'Fortaleza',
        // Adicione mais mapeamentos conforme necessário
    ];

    public function index(Request $request)
    {
        $user = Auth::user();
        $userEmail = $user->email;
        
        // Verifica se o email do usuário está no mapeamento
        $city = $this->emailCityMap[$userEmail] ?? null;
        
        $ano = $request->input('ano', 'todos');
        
        // Filtra reports do tipo fogo/queimada (reports_type_id = 1)
        $query = Report::with(['type', 'user', 'fireLevel'])
            ->where('reports_type_id', 1);
        
        // Se houver cidade mapeada, filtra também por cidade
        if ($city) {
            $query->where('city', $city);
        }
        
        if ($ano !== 'todos') {
            $query->whereYear('created_at', $ano);
        }
        
        $reports = $query->orderBy('created_at', 'desc')->get();
        
        // Dados para gráfico de níveis de fogo
        $dadosFogo = Report::join('fire_levels', 'reports.id', '=', 'fire_levels.reports_id')
            ->select(
                'fire_levels.level as nivel_fogo',
                DB::raw('COUNT(*) as total')
            )
            ->where('reports.reports_type_id', 1)
            ->when($city, fn($q) => $q->where('reports.city', $city))
            ->when($ano !== 'todos', fn($q) => $q->whereYear('reports.created_at', $ano))
            ->groupBy('fire_levels.level')
            ->orderBy('fire_levels.level', 'asc')
            ->get();

        $labelsTipos = $dadosFogo->pluck('nivel_fogo');
        $valuesTipos = $dadosFogo->pluck('total');
        
        // Calcula estatísticas por mês - Mês com MAIS denúncias
        $statsQuery = Report::where('reports_type_id', 1);
        if ($city) {
            $statsQuery->where('city', $city);
        }
        
        $reportsByMonth = $statsQuery->selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('total', 'desc')
            ->first();

        // Calcula estatísticas por mês - Mês com MENOS denúncias
        $statsQueryLeast = Report::where('reports_type_id', 1);
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
                'name' => $monthNames[(int)$reportsByMonth->month] . '/' . $reportsByMonth->year,
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
                'name' => $monthNames[(int)$reportsByLeastMonth->month] . '/' . $reportsByLeastMonth->year,
                'total' => $reportsByLeastMonth->total
            ];
        }
        
        return view('fire', [
            'user' => $user,
            'city' => $city,
            'reports' => $reports,
            'labelsTipos' => $labelsTipos,
            'valuesTipos' => $valuesTipos,
            'peakMonth' => $peakMonth,
            'leastMonth' => $leastMonth,
            'ano' => $ano
        ]);
    }
}