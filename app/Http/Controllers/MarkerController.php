<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    public function index()
    {
        return response()->json(Marker::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'tipe' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $marker = Marker::create($validated);
        return response()->json($marker, 201);
    }

    public function show($id)
    {
        $marker = Marker::findOrFail($id);
        return response()->json($marker);
    }

    public function update(Request $request, $id)
    {
        $marker = Marker::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'tipe' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $marker->update($validated);
        return response()->json($marker);
    }

    public function destroy($id)
    {
        $marker = Marker::findOrFail($id);
        $marker->delete();
        return response()->json(['message' => 'Marker berhasil dihapus']);
    }
}