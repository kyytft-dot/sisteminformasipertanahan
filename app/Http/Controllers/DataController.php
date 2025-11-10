<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class DataController extends Controller
{
    /**
     * Display data page with all tables
     */
    public function index()
    {
        try {
            // Get all data from tables with error handling
            $penduduk = DB::table('penduduk')
                ->orderBy('created_at', 'desc')
                ->get();
                
            $polygon = DB::table('polygon')
                ->orderBy('created_at', 'desc')
                ->get();
                
            $polyline = DB::table('polyline')
                ->orderBy('created_at', 'desc')
                ->get();
                
            $marker = DB::table('marker')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('data', compact('penduduk', 'polygon', 'polyline', 'marker'));
            
        } catch (Exception $e) {
            // Log error and return view with empty collections
            Log::error('Error in DataController@index: ' . $e->getMessage());
            
            return view('data', [
                'penduduk' => collect(),
                'polygon' => collect(),
                'polyline' => collect(),
                'marker' => collect()
            ]);
        }
    }
}