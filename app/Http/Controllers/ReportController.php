<?php
    namespace App\Http\Controllers;

    use App\Models\Report;
    use App\Models\ReportType;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;

    class ReportController extends Controller
    {
        public function __construct()
        {
            $this->middleware('auth:sanctum');
        }

        public function getTypes()
        {
            return response()->json(ReportType::all());
        }

        public function store(Request $request)
        {
            $request->validate([
                'reports_type_id' => 'required|exists:reports_types,id',
                'latitude'        => 'required|numeric',
                'longitude'       => 'required|numeric',
                'address'         => 'nullable|string',
                'img'             => 'nullable|string', 
                'obs'             => 'nullable|string',
            ]);

            try {
                $report = Report::create([
                    'reports_type_id' => $request->reports_type_id,
                    'user_id'         => Auth::id(),
                    'latitude'        => $request->latitude,
                    'longitude'       => $request->longitude,
                    'address'         => $request->address,
                    'img'             => $request->img,
                    'obs'             => $request->obs,
                ]);

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

        public function myReports()
        {
            $reports = Report::where('user_id', Auth::id())
                ->with('type')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($reports);
        }
    }