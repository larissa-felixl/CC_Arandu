<?php

namespace App\Http\Controllers;

use App\Models\FireLevel;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Enums\FireLevelEnum;

class FireLevelController extends Controller
{
 
    public function setLevel(Request $request)
{
    $report = Report::find($request->report_id);

    if (! $report) {
        return response()->json([
            'message' => 'Denúncia não encontrada',
            'data' => [
                'report_id' => $request->report_id
            ]
        ], 404);
    }


    $enum = FireLevelEnum::tryFrom($request->level);

    if (!$enum) {
        return response()->json([
            'message' => 'Nível da queimada inválido. Use 1 (Controlado), 2 (Espalhando), 3 (Prejudicial) ou 4 (Incontrolável).',
            'data' => [
                'report_id' => $request->report_id,
                'level_enviado' => $request->level
            ]
        ], 422);
    }

    $fireLevel = FireLevel::updateOrCreate(
        ['reports_id' => $report->id],
        ['level' => $enum->value]
    );

    return response()->json([
        'message' => 'Fire level successfully updated!',
        'data' => [
            'level_id' => $enum->value,
            'level' => $enum->label()
        ]
    ], 200);
}

    // public function getLevel($reportId)
    // {
    //     $fireLevel = FireLevel::where('reports_id', $reportId)->first();

    //     if (!$fireLevel) {
    //         return response()->json(['message' => 'No fire level defined for this report'], 404);
    //     }

    //     $enum = FireLevelEnum::tryFrom($fireLevel->level);

    //     return response()->json([
    //         'level_id'   => $fireLevel->level,
    //         'level' => $enum?->label() ?? 'Unknown'
    //     ]);
    // }
}