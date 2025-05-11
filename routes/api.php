<?php

use App\Http\Controllers\IuranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\PenghuniRumahController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RumahController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    if ($request->user()->email_verified_at === null) {
        return response()->json(['message' => 'Email not verified'], 409);
    }
    return $request->user();
});

// Route::get('/user', function (Request $request) {
//     return UserResource::make(Auth::user());
// });

Route::get('/user', [UserController::class, 'getUser'])
    // ->middleware('auth:sanctum')
    ->name('user');

Route::get('/reports/monthly/{tahun}', [ReportController::class, 'apiMonthlyReport']);
// Route::resource('penghuni', PenghuniController::class);
Route::get('/penghuni', [PenghuniController::class, 'index'])->name('penghuni.index');
Route::get('/penghuni/get', [PenghuniController::class, 'getAll'])->name('penghuni.get');
Route::post('/penghuni', [PenghuniController::class, 'store'])->name('penghuni.store');
Route::put('/penghuni/{id}', [PenghuniController::class, 'update']);
Route::post('/penghuni/{id}', [PenghuniController::class, 'update']);


Route::post('/rumah/tambah-penghuni', [PenghuniRumahController::class, 'store'])->name('penghuni-rumah.store');
// routes/api.php
Route::get('/rumah/{id}/riwayat-penghuni', [RumahController::class, 'riwayatPenghuni']);
Route::get('/rumah/{id}/penghuni-aktif', [RumahController::class, 'penghuniAktif']);
Route::get('/rumah', [RumahController::class, 'index'])->name('rumah.index');
Route::post('/rumah', [RumahController::class, 'store'])->name('rumah.store');
Route::post('/rumah/{id}', [RumahController::class, 'update'])->name('rumah.update');

Route::get('/pembayaran/{id}/rekap', [PembayaranController::class, 'rekapMonthly']);
Route::get('/pembayaran/', [PembayaranController::class, 'index']);
Route::post('/pembayaran/store', [PembayaranController::class, 'store']);

Route::get('/pengeluaran', [PengeluaranController::class, 'index']);
Route::post('/pengeluaran', [PengeluaranController::class, 'store']);



Route::get('/iuran/', [IuranController::class, 'index']);



// routes/api.php

Route::put('/penghuni-rumah/{id}/selesaikan', [PenghuniRumahController::class, 'selesaikan']);

// Route::post('rumah/{rumah}/assign-penghuni', [RumahController::class, 'assignPenghuni'])->name('rumah.assign-penghuni');
// Route::get('rumah/{rumah}/history', [RumahController::class, 'history'])->name('rumah.history');
// Route::resource('pembayaran', PembayaranController::class);
// Route::get('pembayaran/report', [PembayaranController::class, 'report'])->name('pembayaran.report');
// Route::get('pembayaran/{tahun}/{bulan}', [PembayaranController::class, 'bulanan'])->name('pembayaran.bulanan');
// Route::resource('pengeluaran', PengeluaranController::class);
// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');