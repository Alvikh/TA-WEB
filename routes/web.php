<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AuthControllerWEB;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\EnergyAnalyticsController;
use App\Http\Controllers\Admin\ServerMonitoringControllers;
use App\Http\Controllers\Admin\BroadcastController;
use App\Http\Controllers\Auth\NewPasswordController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/test-api', function () {
//     return response()->json(['message' => 'API works!']);
// });

Route::get('/', function () {
    return view('index');
});
Route::post('/register', [AuthControllerWEB::class, 'register']);
Route::post('/login', [AuthControllerWEB::class, 'login']);
Route::get('/admin', function () {
    return view('welcomePage');
});

// Route::middleware(['admin','auth'])->group(function () {
    Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/server', [ServerMonitoringControllers::class, 'index'])->name('admin.server.monitoring');
    });


Route::resource('users', UserController::class);
Route::get('/devices/analytics/monitor', [EnergyAnalyticsController::class, 'monitor'])->name('devices.monitor');
Route::get('/devices/analytics/{id}', [EnergyAnalyticsController::class, 'show'])->name('devices.analytic.show');
Route::get('/devices/analytics/{id}/consumption', [EnergyAnalyticsController::class, 'getConsumption']);
Route::post('/devices/analytics/{id}/prediction', [EnergyAnalyticsController::class, 'getPrediction']);
Route::resource('/devices/analytics/monitor', EnergyAnalyticsController::class);
Route::resource('devices/analytics/monitor', EnergyAnalyticsController::class)->only([
    'show'
]);
Route::post('/api/devices/{id}/prediction', [EnergyAnalyticsController::class, 'getPrediction']);

// Route::get('/devices/monitor/{id}', [EnergyAnalyticsController,'index'])->name('devices.monitor');
Route::patch('/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
Route::patch('/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
Route::patch('/{device}/activate', [UserController::class, 'activate'])->name('devices.activate');
Route::patch('/{device}/deactivate', [UserController::class, 'deactivate'])->name('devices.deactivate');
Route::post('/monitoring', [BrokerController::class, 'store']);
Route::get('/monitoring', [BrokerController::class, 'index'])->name('devices.monitoring');
Route::get('/monitoring/energy', [MonitoringController::class, 'index'])->name('monitoring.index');
Route::get('/devices/{device}/predict', [EnergyAnalyticsController::class, 'getPredictions'])
    ->name('devices.predict');
Route::resource('devices', DeviceController::class);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // Route::get('/dashboard', [DashboardController::class,"index"])->name('dashboard');
});

Route::get('/devices/export/pdf', [DeviceController::class, 'exportPdf'])->name('devices.export.pdf');
Route::get('/devices/export/excel', [DeviceController::class, 'exportExcel'])->name('devices.export.excel');
Route::get('/devices/{device}/export-pdf', [DeviceController::class, 'exportDetailPdf'])->name('devices.export.detail');
Route::get('/users/export/pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');
Route::get('/users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
Route::get('/users/{user}/export-pdf', [UserController::class, 'exportDetailPdf'])->name('users.export.detail');
Route::get('/admin/server-monitoring/export-pdf', [ServerMonitoringControllers::class, 'exportPDF'])->name('admin.server.export');

Route::get('/broadcast', [BroadcastController::class, 'index'])->name('broadcast.index'); // Menampilkan form + data user
Route::post('/broadcast/send', [BroadcastController::class, 'send'])->name('broadcast.send'); // Kirim ke semua user
Route::post('/broadcast/send-selected', [BroadcastController::class, 'sendSelected'])->name('broadcast.send.selected'); // Kirim ke user terpilih

Route::post('/forgot-password', [NewPasswordController::class, 'forgotPassword']);
Route::get('/reset-password/{token}', [NewPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'resetPassword'])->name('password.update');
// });

Route::get('/energy-analytics/{id}/export-pdf', [EnergyAnalyticsController::class, 'exportPdf'])->name('energy-analytics.exportPdf');
Route::get('/test-flask-connection', function() {
    try {
        $response = Http::timeout(3)->get('http://103.219.251.171:5050/');
        return [
            'status' => $response->status(),
            'body' => $response->body()
        ];
    } catch (\Exception $e) {
        return [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    }
});