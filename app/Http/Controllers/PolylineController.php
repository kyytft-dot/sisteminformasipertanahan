<?php

namespace App\Http\Controllers;

use App\Models\Polyline;
use Illuminate\Http\Request;

class PolylineController extends Controller
{
    public function index()
    {
        return response()->json(Polyline::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'jarak' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'warna' => 'required|string|max:7',
            'coordinates' => 'required|string'
        ]);

        $polyline = Polyline::create($validated);
        return response()->json($polyline, 201);
    }

    public function show($id)
    {
        $polyline = Polyline::findOrFail($id);
        return response()->json($polyline);
    }

    public function update(Request $request, $id)
    {
        $polyline = Polyline::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'jarak' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'warna' => 'required|string|max:7',
            'coordinates' => 'required|string'
        ]);

        $polyline->update($validated);
        return response()->json($polyline);
    }

    public function destroy($id)
    {
        $polyline = Polyline::findOrFail($id);
        $polyline->delete();
        return response()->json(['message' => 'Polyline berhasil dihapus']);
    }
}
