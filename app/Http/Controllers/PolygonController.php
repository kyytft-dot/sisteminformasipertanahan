<?php

namespace App\Http\Controllers;

use App\Models\Polygon;
use Illuminate\Http\Request;

class PolygonController extends Controller
{
    public function index()
    {
        return response()->json(Polygon::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'luas' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'warna' => 'required|string|max:7',
            'coordinates' => 'required|string'
        ]);

        $polygon = Polygon::create($validated);
        return response()->json($polygon, 201);
    }

    public function show($id)
    {
        $polygon = Polygon::findOrFail($id);
        return response()->json($polygon);
    }

    public function update(Request $request, $id)
    {
        $polygon = Polygon::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'luas' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'warna' => 'required|string|max:7',
            'coordinates' => 'required|string'
        ]);

        $polygon->update($validated);
        return response()->json($polygon);
    }

    public function destroy($id)
    {
        $polygon = Polygon::findOrFail($id);
        $polygon->delete();
        return response()->json(['message' => 'Polygon berhasil dihapus']);
    }
}