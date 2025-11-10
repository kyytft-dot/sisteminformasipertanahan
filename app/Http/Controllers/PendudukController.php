<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index()
    {
        return response()->json(Penduduk::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:16|unique:penduduk',
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $penduduk = Penduduk::create($validated);
        return response()->json($penduduk, 201);
    }

    public function show($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        return response()->json($penduduk);
    }

    public function update(Request $request, $id)
    {
        $penduduk = Penduduk::findOrFail($id);
        
        $validated = $request->validate([
            'nik' => 'required|string|max:16|unique:penduduk,nik,' . $id,
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $penduduk->update($validated);
        return response()->json($penduduk);
    }

    public function destroy($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}