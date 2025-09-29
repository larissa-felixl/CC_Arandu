<?php
namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\FireLevel;
use App\Enums\FireLevelEnum;

class ReportController extends Controller
{
    // Relatório por cidade (apenas admins)
    public function reportByCity(Request $request)
    {
        $request->validate([
            'city' => 'required|string',
        ]);

        $city = \App\Models\City::where('name', $request->city)->first();
        if (!$city) {
            return response()->json(['message' => 'Cidade não encontrada'], 404);
        }

        $total = \App\Models\Report::where('city_id', $city->id)->count();

        $byType = \App\Models\Report::where('city_id', $city->id)
            ->select('reports_type_id', \DB::raw('count(*) as total'))
            ->groupBy('reports_type_id')
            ->get();

        $byFireLevel = \App\Models\FireLevel::whereIn('reports_id', function($query) use ($city) {
                $query->select('id')->from('reports')->where('city_id', $city->id);
            })
            ->select('level', \DB::raw('count(*) as total'))
            ->groupBy('level')
            ->get();

        return response()->json([
            'city' => $city->name,
            'total_reports' => $total,
            'by_type' => $byType,
            'by_fire_level' => $byFireLevel,
        ]);
    }
        public function __construct()
        {
            //$this->middleware('auth:sanctum');
        }

        public function getTypes()
        {
            return response()->json(ReportType::all());
        }

        public function store(Request $request)
        {
            $request->validate([
                'reports_type_id' => 'required|exists:reports_types,id',
                'coordinate'      => 'required|string',
                'img'             => 'nullable|string', 
                'obs'             => 'nullable|string',
                'fire_level_name' => 'nullable|string',
            ]);

            try {
                // Extrair latitude e longitude da string coordinate (esperado: "lat,lng")
                $lat = null;
                $lng = null;
                if (preg_match('/^([-\d.]+),\s*([-\d.]+)$/', $request->coordinate, $matches)) {
                    $lat = $matches[1];
                    $lng = $matches[2];
                }

                $cityId = null;
                if ($lat && $lng) {
                    $cityName = $this->getCityFromCoordinates($lat, $lng);
                    if ($cityName) {
                        $city = \App\Models\City::firstOrCreate(['name' => $cityName]);
                        $cityId = $city->id;
                    }
                }

                $report = Report::create([
                    'reports_type_id' => $request->reports_type_id,
                    'user_id'         => Auth::id(),
                    'city_id'         => $cityId,
                    'coordinate'      => $request->coordinate,
                    'img'             => $request->img,
                    'obs'             => $request->obs,
                ]);

                if ($report->reports_type_id == 1 && $request->filled('fire_level_name')) {
                    $enum = FireLevelEnum::fromLabel($request->fire_level_name);

                    if ($enum) {
                        FireLevel::create([
                            'reports_id' => $report->id,
                            'level'      => $enum->value,
                        ]);
                    }
                }

                return response()->json([
                    'message' => 'Denúncia registrada com sucesso!',
                    'report'  => $report
                ], 201);

            } catch (\Exception $e) {
                Log::error('Erro ao registrar denúncia: ' . $e->getMessage());

                return response()->json([
                    'message' => 'Ocorreu um erro ao registrar a denúncia. Tente novamente mais tarde.'
                ], 500);
            }
        }

        // Geocodificação reversa usando OpenCage
        private function getCityFromCoordinates($lat, $lng)
        {
            $apiKey = env('OPENCAGE_API_KEY');
            if (!$apiKey) return null;
            $url = "https://api.opencagedata.com/geocode/v1/json?q={$lat}+{$lng}&key={$apiKey}&language=pt&pretty=1";
            try {
                $response = \Illuminate\Support\Facades\Http::get($url);
                if (isset($response['results'][0]['components']['city'])) {
                    return $response['results'][0]['components']['city'];
                }
                if (isset($response['results'][0]['components']['town'])) {
                    return $response['results'][0]['components']['town'];
                }
                if (isset($response['results'][0]['components']['village'])) {
                    return $response['results'][0]['components']['village'];
                }
            } catch (\Exception $e) {
                \Log::error('Erro ao buscar cidade por coordenada: ' . $e->getMessage());
            }
            return null;
        }

        public function myReports()
        {
            $reports = Report::where('user_id', Auth::id())
                ->with('type')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($reports);
        }
    }