<?php

namespace App\Http\Controllers;

use App\Models\FireLevel;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Enums\FireLevelEnum;

class FireLevelController extends Controller
{
 
    public function setLevel(Request $request, $reportId)
    {
        $request->validate([
            'level_name' => 'required|string',
        ]);

        $report = Report::findOrFail($reportId);

        $enum = FireLevelEnum::fromLabel($request->level_name);

        if (!$enum) {
            return response()->json([
                'message' => 'Invalid fire level. Use: Controlled Fire, Spreading Fire, Harmful Fire, or Uncontrollable Fire.'
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
                'level_name' => $enum->label()
            ]
        ], 200);
    }

    public function getLevel($reportId)
    {
        $fireLevel = FireLevel::where('reports_id', $reportId)->first();

        if (!$fireLevel) {
            return response()->json(['message' => 'No fire level defined for this report'], 404);
        }

        $enum = FireLevelEnum::tryFrom($fireLevel->level);

        return response()->json([
            'level_id'   => $fireLevel->level,
            'level_name' => $enum?->label() ?? 'Unknown'
        ]);
    }
}