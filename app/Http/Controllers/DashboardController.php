<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Report;

class DashboardController extends Controller
{
    private $emailCityMap = [
        'teste@gmail.com' => 'Fortaleza',
        // 'outro@gmail.com' => 'Fortaleza',
        // 'usuario@gmail.com' => 'Limoeiro do Norte',
    ];

    public function index(Request $request)
    {
        $user = Auth::user();
        $userEmail = $user->email;

        $city = $this->emailCityMap[$userEmail] ?? null;

        $reportsQuery = Report::with(['type', 'user', 'fireLevel']);

        if ($city) {
            $reportsQuery->where('city', $city);
        }

        $reports = $reportsQuery->orderBy('created_at', 'desc')->get();

        $ano = $request->input('ano', 'todos');
        $mes = $request->input('mes', 'todos');

        $query = DB::table('reports')
            ->select('neighborhood', DB::raw('COUNT(*) as total'))
            ->groupBy('neighborhood')
            ->orderByDesc('total');

        if ($city) {
            $query->where('city', $city);
        }

        if ($ano !== 'todos') {
            $query->whereYear('created_at', $ano);
        }

        if ($mes !== 'todos') {
            $query->whereMonth('created_at', $mes);
        }

        $bairros = $query->limit(10)->get();

        $labelsBairros = $bairros->pluck('neighborhood');
        $valuesBairros = $bairros->pluck('total');

        $statsQuery = Report::query();
        if ($city) {
            $statsQuery->where('city', $city);
        }

        $reportsByMonth = $statsQuery
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('total', 'desc')
            ->first();

        $statsQueryLeast = Report::query();
        if ($city) {
            $statsQueryLeast->where('city', $city);
        }

        $reportsByLeastMonth = $statsQueryLeast
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('total', 'asc')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->first();

        $monthNames = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];

        $peakMonth = $reportsByMonth ? [
            'name' => $monthNames[(int)$reportsByMonth->month] . '/' . $reportsByMonth->year,
            'total' => $reportsByMonth->total
        ] : null;

        $leastMonth = $reportsByLeastMonth ? [
            'name' => $monthNames[(int)$reportsByLeastMonth->month] . '/' . $reportsByLeastMonth->year,
            'total' => $reportsByLeastMonth->total
        ] : null;

        return view('dashboard', [
            'user' => $user,
            'city' => $city,
            'reports' => $reports,
            'labelsBairros' => $labelsBairros,
            'valuesBairros' => $valuesBairros,
            'peakMonth' => $peakMonth,
            'leastMonth' => $leastMonth
        ]);
    }
}
