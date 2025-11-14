<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class GarbageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Filtra apenas reports do tipo lixo (reports_type_id = 2)
        $reports = Report::with(['type', 'user'])
            ->where('reports_type_id', 2)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('garbage', [
            'user' => $user,
            'reports' => $reports
        ]);
    }
}
