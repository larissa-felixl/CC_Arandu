<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Report;

    class ReportTypeController extends Controller
    {

        public function storeFire(Request $request)
        {
            $request->validate([
                'observations' => 'required|string',
                'coordinate'      => 'required|string',
                'user_id'      => 'required|integer|exists:usuarios,id',
            ]);

            $report = Report::create([
                'observacoes'        => $request->observations,
                'coordenadas'           => $request->coordinate,
                'usuario_id'         => $request->user_id,
                'tipo_denuncias_id'  => 1, 
            ]);

            return response()->json([
                'message' => 'Fire report successfully registered!',
                'report'  => $report
            ], 201);
        }

        public function storeGarbage(Request $request)
        {
            $request->validate([
                'observations' => 'required|string',
                'coordinate'   => 'required|string',
                'user_id'      => 'required|integer|exists:usuarios,id',
            ]);

            $report = Report::create([
                'observacoes'        => $request->observations,
                'coordenadas'        => $request->coordinate,
                'usuario_id'         => $request->user_id,
                'tipo_denuncias_id'  => 2, 
            ]);

            return response()->json([
                'message' => 'Garbage report successfully registered!',
                'report'  => $report
            ], 201);
        }
    }