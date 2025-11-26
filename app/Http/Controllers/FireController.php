<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use Illuminate\Support\Facades\DB;

class FireController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $city = $user->city ?? null;

        $reports = Report::with(['fireLevel'])
            ->when($city, fn($q) => $q->where('city', $city))
            ->where('reports_type_id', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        $dadosFogo = Report::join('fire_levels', 'reports.id', '=', 'fire_levels.reports_id')
            ->select(
                'fire_levels.level as nivel_fogo',
                DB::raw('COUNT(*) as total')
            )
            ->when($city, fn($q) => $q->where('reports.city', $city))
            ->groupBy('fire_levels.level')
            ->orderBy('fire_levels.level', 'asc')
            ->get();

        $labelsTipos = $dadosFogo->pluck('nivel_fogo');
        $valuesTipos = $dadosFogo->pluck('total');


        $monthNames = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];

        // Mês com mais denúncias
        $peakRaw = Report::selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->when($city, fn($q) => $q->where('city', $city))
            ->where('reports_type_id', 1)
            ->groupBy('year', 'month')
            ->orderBy('total', 'desc')
            ->first();

        $peakMonth = $peakRaw
            ? [
                'name' => $monthNames[$peakRaw->month] . '/' . $peakRaw->year,
                'total' => $peakRaw->total
            ]
            : null;

        // Mês com menos denúncias
        $leastRaw = Report::selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->when($city, fn($q) => $q->where('city', $city))
            ->where('reports_type_id', 1)
            ->groupBy('year', 'month')
            ->orderBy('total', 'asc')
            ->first();

        $leastMonth = $leastRaw
            ? [
                'name' => $monthNames[$leastRaw->month] . '/' . $leastRaw->year,
                'total' => $leastRaw->total
            ]
            : null;

        return view('fire', [
            'user'        => $user,
            'city'        => $city,
            'reports'     => $reports,
            'chartData'   => $dadosFogo,
            'labelsTipos' => $labelsTipos,
            'valuesTipos' => $valuesTipos,
            'peakMonth'   => $peakMonth,
            'leastMonth'  => $leastMonth
        ]);
    }
}
