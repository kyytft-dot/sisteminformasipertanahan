<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// === CONTROLLER YANG SUDAH ADA ===
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PolygonController;
use App\Http\Controllers\PolylineController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\RealtimeNotificationController;

// === TAMBAHAN BARU UNTUK PROFIL & FOTO & PASSWORD ===
use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {

    // 2. ROUTE GEOJSON UNTUK MINI MAP DI DASHBOARD & PETA
    Route::prefix('penduduk')->name('penduduk.')->group(function () {
        Route::get('/penduduk', [PendudukController::class, 'geojson'])->name('penduduk');
    });

    Route::prefix('polygon')->name('polygon.')->group(function () {
        Route::get('/polygon', [PolygonController::class, 'geojson'])->name('polygon');
    });

    Route::prefix('polyline')->name('polyline.')->group(function () {
        Route::get('/polyline', [PolylineController::class, 'geojson'])->name('polyline');
    });

    Route::prefix('marker')->name('marker.')->group(function () {
        Route::get('/marker', [MarkerController::class, 'geojson'])->name('marker');
    });

});

// ========================================
// 1. LOGIN & LOGOUT
// ========================================
Route::get('/login', function () {
    if (Auth::check()) return redirect('/');
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/dashboard');
    }
    return back()->with('error', 'Email atau password salah!');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// ========================================
// 2. SEMUA YANG HARUS LOGIN DULU
// ========================================
Route::middleware('auth')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // === USER MASYARAKAT HANYA BISA INI ===
    Route::get('/peta', fn() => view('lihat-peta'));
    Route::get('/ten', fn() => view('tentang'));
    // UPDATE: Chatbot sekarang BISA DIAKSES TANPA LOGIN (PUBLIC) agar tombol di landing page bisa langsung masuk
    // Route::get('/chatbot', fn() => view('chatbot'));

    // ===================================================================
    // PENGATURAN PROFIL — BARU & BENAR (PAKAI PATCH (TIDAK ERROR LAGI!)
    // ===================================================================
    Route::get('/pengaturan', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');           // PATCH
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');     // POST foto
    Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update'); // POST password

    // ===================================================================
    // ROUTE LAMA TETAP DIPER TAHAN KAN (TIDAK DIHAPUS SATU PUN!)
    // ===================================================================
    Route::post('/pengaturan/profile', [App\Http\Controllers\PengaturanController::class, 'updateProfile']);
    Route::post('/pengaturan/password', [App\Http\Controllers\PengaturanController::class, 'updatePassword']);
    Route::post('/pengaturan/lang', [App\Http\Controllers\PengaturanController::class, 'setLanguage']);

    // === HANYA ADMIN & STAFF YANG BISA MASUK SINI ===
    Route::get('/petnah', function () {
        $user = Auth::user();
        if ($user->hasRole('admin') || $user->hasRole('staff')) {
            return view('peta-pertanahan');
        }
        return redirect('/peta')->with('error', 'Akses ditolak! Anda bukan staff/admin.');
    });

    // User management (only admin)
    Route::get('/users', function() {
        if(!auth()->user() || !auth()->user()->hasRole('admin')){
            abort(403, 'Akses ditolak');
        }
        return view('users.iframe');
    })->middleware('auth')->name('users.index');

    Route::get('/users/list', [App\Http\Controllers\UserManagementController::class, 'list'])->middleware('auth');
    Route::get('/users/{id}', [App\Http\Controllers\UserManagementController::class, 'show'])->middleware('auth');
    Route::post('/users', [App\Http\Controllers\UserManagementController::class, 'store'])->middleware('auth');
    Route::post('/users/invite', [App\Http\Controllers\UserManagementController::class, 'invite'])->middleware('auth');
    Route::get('/users/invite/manual/{inviteCode}', [App\Http\Controllers\UserManagementController::class, 'manualInvite'])->middleware('auth');
    Route::put('/users/{id}', [App\Http\Controllers\UserManagementController::class, 'update'])->middleware('auth');
    Route::delete('/users/{id}', [App\Http\Controllers\UserManagementController::class, 'destroy'])->middleware('auth');

    Route::get('/datnah', function () {
        if (Auth::user()->hasRole('admin|staff')) {
            return view('datatanah');
        }
        return redirect('/')->with('error', 'Akses ditolak!');
    })->name('data-tanah.index');

    Route::get('/lap', function () {
        if (Auth::user()->hasRole('admin|staff')) {
            return view('laporan');
        }
        return redirect('/')->with('error', 'Akses ditolak!');
    })->name('laporan.index');

    // Realtime notifications (JSON / SSE)
    Route::get('/realtime/notifications', [RealtimeNotificationController::class, 'index']);
    Route::get('/sse/notifications', [RealtimeNotificationController::class, 'stream']);

    Route::get('/paper', function () {
        if (Auth::user()->hasRole('admin|staff')) {
            return view('geopaper');
        }
        return redirect('/')->with('error', 'Akses ditolak!');
    });

    // === HANYA ADMIN ===
    Route::get('/data', function () {
        if (Auth::user()->hasRole('admin')) {
            return app(App\Http\Controllers\DataController::class)->index();
        }
        return redirect('/')->with('error', 'Hanya Admin!');
    })->name('data.index')->middleware('role:admin');

    Route::resource('jenis-tanah', App\Http\Controllers\JenisTanahController::class)->middleware('role:admin');

    // Penduduk, Polygon, Polyline, Marker → HANYA ADMIN
    Route::prefix('penduduk')->group(function () {
        Route::get('/penduduk', [App\Http\Controllers\PendudukController::class, 'index']);
        Route::post('/penduduk', [App\Http\Controllers\PendudukController::class, 'store']);
        Route::get('/penduduk/{id}', [App\Http\Controllers\PendudukController::class, 'show']);
        Route::put('/penduduk/{id}', [App\Http\Controllers\PendudukController::class, 'update']);
        Route::delete('/penduduk/{id}', [App\Http\Controllers\PendudukController::class, 'destroy']);
    })->middleware('role:admin');

    Route::prefix('polygon')->group(function () {
        Route::get('/polygon', [App\Http\Controllers\PolygonController::class, 'index']);
        Route::post('/polygon', [App\Http\Controllers\PolygonController::class, 'store']);
        Route::get('/polygon/{id}', [App\Http\Controllers\PolygonController::class, 'show']);
        Route::put('/polygon/{id}', [App\Http\Controllers\PolygonController::class, 'update']);
        Route::delete('/polygon/{id}', [App\Http\Controllers\PolygonController::class, 'destroy']);
    })->middleware('role:admin');

    Route::prefix('polyline')->group(function () {
        Route::get('/polyline', [App\Http\Controllers\PolylineController::class, 'index']);
        Route::post('/polyline', [App\Http\Controllers\PolylineController::class, 'store']);
        Route::get('/polyline/{id}', [App\Http\Controllers\PolylineController::class, 'show']);
        Route::put('/polyline/{id}', [App\Http\Controllers\PolylineController::class, 'update']);
        Route::delete('/polyline/{id}', [App\Http\Controllers\PolylineController::class, 'destroy']);
    })->middleware('role:admin');

    Route::prefix('marker')->group(function () {
        Route::get('/marker', [App\Http\Controllers\MarkerController::class, 'index']);
        Route::post('/marker', [App\Http\Controllers\MarkerController::class, 'store']);
        Route::get('/marker/{id}', [App\Http\Controllers\MarkerController::class, 'show']);
        Route::put('/marker/{id}', [App\Http\Controllers\MarkerController::class, 'update']);
        Route::delete('/marker/{id}', [App\Http\Controllers\MarkerController::class, 'destroy']);
    })->middleware('role:admin');

    // CEK DB
    Route::get('/cekdb', fn() => "DB: " . DB::connection()->getDatabaseName());
});

// ========================================
// 3. FRONTEND PUBLIC
// ========================================
Route::get('/', function () {
    return view('frontend');
})->name('frontend');

// === UPDATE: ROUTE CHATBOT DIPINDAHKAN KE PUBLIC AGAR BISA DIAKSES DARI LANDING PAGE TANPA LOGIN ===
Route::get('/chatbot', function () {
    return view('chatbot');
})->name('chatbot');

// ========================================
// 4. SEMUA YANG BELUM LOGIN → KE LOGIN
// ========================================
Route::get('{any}', function () {
    return redirect('/login');
})->where('any', '.*')->middleware('guest');