<?php

namespace App\Http\Controllers;

use App\Models\JenisTanah;
use Illuminate\Http\Request;

class JenisTanahController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $jenisTanah = JenisTanah::all();
        return response()->json($jenisTanah);
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:100',
        ]);

        // Tentukan warna otomatis berdasarkan jenis
        $warna = match (strtolower($request->nama_jenis)) {
            'permukiman' => '#FF0000',
            'perairan' => '#0000FF',
            'hutan', 'kebun', 'pegunungan' => '#008000',
            default => '#CCCCCC',
        };

        $jenisTanah = JenisTanah::create([
            'nama_jenis' => ucfirst($request->nama_jenis),
            'warna_polygon' => $warna
        ]);

        return response()->json(['message' => 'Data berhasil ditambahkan', 'data' => $jenisTanah]);
    }

    // Ubah data
    public function update(Request $request, $id)
    {
        $jenisTanah = JenisTanah::findOrFail($id);
        $request->validate([
            'nama_jenis' => 'required|string|max:100',
        ]);

        $warna = match (strtolower($request->nama_jenis)) {
            'permukiman' => '#FF0000',
            'perairan' => '#0000FF',
            'hutan', 'kebun', 'pegunungan' => '#008000',
            default => '#CCCCCC',
        };

        $jenisTanah->update([
            'nama_jenis' => ucfirst($request->nama_jenis),
            'warna_polygon' => $warna
        ]);

        return response()->json(['message' => 'Data berhasil diubah', 'data' => $jenisTanah]);
    }

    // Hapus data
    public function destroy($id)
    {
        $jenisTanah = JenisTanah::findOrFail($id);
        $jenisTanah->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
