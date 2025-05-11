<?php

namespace App\Http\Controllers;

use App\Models\PenghuniRumah;
use App\Models\Rumah;
use Illuminate\Http\Request;

class PenghuniRumahController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rumah_id' => 'required|exists:rumah,id',
            'penghuni_id' => 'required|exists:penghuni,id',
            'tanggal_mulai' => 'required|date'
        ]);

        // Optional: pastikan tidak ada penghuni aktif sebelum menambahkan
        // $aktif = PenghuniRumah::where('rumah_id', $validated['rumah_id'])
        //     ->whereNull('tanggal_selesai')
        //     ->exists();

        // if ($aktif) {
        //     return response()->json(['message' => 'Masih ada penghuni aktif'], 409);
        // }

        $penghuni = PenghuniRumah::create($validated);

        return response()->json(['message' => 'Penghuni ditambahkan', 'data' => $penghuni]);
    }
    public function selesaikan($id, Request $request)
    {
        $validated = $request->validate([
            'tanggal_selesai' => 'nullable|date',
        ]);

        $penghuniRumah = PenghuniRumah::findOrFail($id);

        // Use provided date or default to today
        $tanggalSelesai = $validated['tanggal_selesai'] ?? now()->format('Y-m-d');

        $penghuniRumah->update([
            'tanggal_selesai' => $tanggalSelesai,
        ]);

        // Check if there are other active penghuni in the same rumah
        $hasActivePenghuni = PenghuniRumah::where('rumah_id', $penghuniRumah->rumah_id)
            ->whereNull('tanggal_selesai')
            ->exists();

        // Update rumah status if no active penghuni
        if (!$hasActivePenghuni) {
            Rumah::where('id', $penghuniRumah->rumah_id)
                ->update(['status_penghuni' => 'tidak_dihuni']);
        }

        return response()->json([
            'message' => 'Kontrak berhasil diselesaikan',
            'data' => $penghuniRumah
        ]);
    }
}
