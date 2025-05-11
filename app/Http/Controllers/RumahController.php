<?php

namespace App\Http\Controllers;

use App\Models\Rumah;
use App\Models\Penghuni;
use App\Models\PenghuniRumah;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RumahController extends Controller
{
    public function index()
    {
        $rumah = Rumah::with(['penghuniRumah.penghuni'])->get();

        return response()->json([
            'data' => $rumah->map(function ($item) {

                $penghuniAktif = $item->penghuniRumah->first(function ($pr) {
                    return is_null($pr->tanggal_selesai) || Carbon::parse($pr->tanggal_selesai)->gt(now());
                });

                return [
                    'id' => $item->id,
                    'nomor_rumah' => $item->nomor_rumah,
                    'status_penghuni' => $penghuniAktif ? 'dihuni' : 'tidak_dihuni',
                    'penghuni_rumah' => $item->penghuniRumah->map(function ($pr) {
                        return [
                            'id' => $pr->id,
                            'penghuni' => [
                                'id' => $pr->penghuni->id,
                                'nama_lengkap' => $pr->penghuni->nama_lengkap,
                                'status_penghuni' => $pr->penghuni->status_penghuni,
                            ],
                            'tanggal_mulai' => $pr->tanggal_mulai,
                            'tanggal_selesai' => $pr->tanggal_selesai,
                        ];
                    })->toArray()
                ];
            })
        ]);
    }
    public function getAll() {}

    public function penghuniAktif($rumahId)
    {
        $penghuniAktif = PenghuniRumah::with('penghuni')
            ->where('rumah_id', $rumahId)
            ->where(function ($query) {
                $query->whereNull('tanggal_selesai');
            })
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return response()->json([
            'data' => $penghuniAktif->map(function ($item) {
                return [
                    'id' => $item->id,
                    'penghuni' => [
                        'id' => $item->penghuni->id,
                        'nama_lengkap' => $item->penghuni->nama_lengkap,
                        'status_penghuni' => $item->penghuni->status_penghuni,
                    ],
                    'tanggal_mulai' => $item->tanggal_mulai,
                    'tanggal_selesai' => $item->tanggal_selesai,
                ];
            })
        ]);
    }

    public function riwayatPenghuni($rumahId)
    {
        $riwayat = PenghuniRumah::with('penghuni')
            ->where('rumah_id', $rumahId)
            ->whereNotNull('tanggal_selesai')
            ->orderBy('tanggal_selesai', 'desc')
            ->get();

        return response()->json([
            'data' => $riwayat->map(function ($item) {
                return [
                    'id' => $item->id,
                    'penghuni' => [
                        'id' => $item->penghuni->id,
                        'nama_lengkap' => $item->penghuni->nama_lengkap,
                        'status_penghuni' => $item->penghuni->status_penghuni,
                    ],
                    'tanggal_mulai' => $item->tanggal_mulai,
                    'tanggal_selesai' => $item->tanggal_selesai,
                ];
            })
        ]);
    }

    public function create()
    {
        return view('rumah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_rumah' => 'required|string|max:10|unique:rumah',

        ]);

        Rumah::create($validated);

        return redirect()->route('rumah.index')->with('success', 'Rumah berhasil ditambahkan');
    }

    public function edit(Rumah $rumah)
    {
        return view('rumah.edit', compact('rumah'));
    }

    public function update(Request $request, $id)
    {
        $rumah = Rumah::findOrFail($id);

        $validated = $request->validate([
            'nomor_rumah' => 'required|string|max:10|unique:rumah,nomor_rumah,' . $rumah->id,
        ]);

        $rumah->update($validated);

        return response()->json([
            'message' => 'Data penghuni berhasil diperbarui',
            'data' => $rumah
        ]);
    }

    public function assignPenghuni(Request $request, Rumah $rumah)
    {
        $validated = $request->validate([
            'penghuni_id' => 'required|exists:penghuni,id',
            'tanggal_mulai' => 'required|date'
        ]);

        // Nonaktifkan penghuni sebelumnya jika ada
        $rumah->penghuniRumah()
            ->whereNull('tanggal_selesai')
            ->update(['tanggal_selesai' => now()]);

        // Tambah penghuni baru
        $rumah->penghuniRumah()->create([
            'penghuni_id' => $validated['penghuni_id'],
            'tanggal_mulai' => $validated['tanggal_mulai']
        ]);

        $rumah->update(['status_penghuni' => 'dihuni']);

        return redirect()->route('rumah.index')->with('success', 'Penghuni berhasil ditambahkan ke rumah');
    }

    public function history(Rumah $rumah)
    {
        $history = $rumah->penghuniRumah()->with('penghuni')->get();
        return view('rumah.history', compact('rumah', 'history'));
    }
}
