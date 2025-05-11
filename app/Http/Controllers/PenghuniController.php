<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenghuniController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::with(['penghuniRumah.rumah'])->get();
    
        return response()->json([
            'data' => $penghuni->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_lengkap' => $item->nama_lengkap,
                    'foto_ktp' => $item->foto_ktp,
                    'status_penghuni' => $item->status_penghuni,
                    'nomor_telepon' => $item->nomor_telepon,
                    'status_pernikahan' => $item->status_pernikahan,
                    'rumah' => $item->penghuniRumah->map(function ($pr) {
                        return [
                            'nomor_rumah' => $pr->rumah->nomor_rumah,
                            'tanggal_mulai' => $pr->tanggal_mulai,
                            'tanggal_selesai' => $pr->tanggal_selesai,
                        ];
                    })->toArray()
                ];
            })
        ]);
    }


    public function getAll()
    {
        $penghuni = Penghuni::all();
        return response()->json($penghuni);
    }
    
    public function create()
    {
        return view('penghuni.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'status_penghuni' => 'required|string',
            'nomor_telepon' => 'required|string|max:15',
            'status_pernikahan' => 'required|string',
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Proses upload foto KTP
        if ($request->hasFile('foto_ktp')) {
            $path = $request->file('foto_ktp')->store('ktp', 'public');
            $validated['foto_ktp'] = $path;
        }

        // Simpan data ke database
        $penghuni = Penghuni::create($validated);

        return response()->json([
            'message' => 'Penghuni berhasil ditambahkan',
            'data' => $penghuni
        ], 201);
    }


    public function edit(Penghuni $penghuni)
    {
        return view('penghuni.edit', compact('penghuni'));
    }

    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::find($id);
    
        if (!$penghuni) {
            return response()->json([
                'message' => 'Penghuni tidak ditemukan'
            ], 404);
        }
    
        // Validasi input
        $validated = $request->validate([
            'nama_lengkap' => 'nullable|string|max:255',
            'status_penghuni' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:15',
            'status_pernikahan' => 'nullable|string',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Jika ada file baru dikirim, hapus file lama lalu simpan baru
        if ($request->hasFile('foto_ktp')) {
            // Hapus foto lama jika ada
            if ($penghuni->foto_ktp && \Storage::disk('public')->exists($penghuni->foto_ktp)) {
                \Storage::disk('public')->delete($penghuni->foto_ktp);
            }
    
            // Simpan foto baru
            $path = $request->file('foto_ktp')->store('ktp', 'public');
            $validated['foto_ktp'] = $path;
        }
    
        // Update data
        $penghuni->update($validated);
    
        return response()->json([
            'message' => 'Data penghuni berhasil diperbarui',
            'data' => $penghuni
        ]);
    }
    public function updatePhoto(Request $request, $id)
    {
        $penghuni = Penghuni::find($id);
    
        if (!$penghuni) {
            return response()->json([
                'message' => 'Penghuni tidak ditemukan'
            ], 404);
        }
    
        // Validasi input
        $validated = $request->validate([
            
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Jika ada file baru dikirim, hapus file lama lalu simpan baru
        if ($request->hasFile('foto_ktp')) {
            // Hapus foto lama jika ada
            if ($penghuni->foto_ktp && \Storage::disk('public')->exists($penghuni->foto_ktp)) {
                \Storage::disk('public')->delete($penghuni->foto_ktp);
            }
    
            // Simpan foto baru
            $path = $request->file('foto_ktp')->store('ktp', 'public');
            $validated['foto_ktp'] = $path;
        }
    
        // Update data
        $penghuni->update($validated);
    
        return response()->json([
            'message' => 'Data penghuni berhasil diperbarui',
            'data' => $penghuni
        ]);
    }
    
    public function destroy(Penghuni $penghuni)
    {
        if ($penghuni->foto_ktp) {
            Storage::disk('public')->delete($penghuni->foto_ktp);
        }
        $penghuni->delete();
        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil dihapus');
    }
}