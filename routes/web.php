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
Route::get('/admin', function () {
    return view('welcomePage');
});
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::post('/register', [AuthControllerWEB::class, 'register']);
Route::post('/login', [AuthControllerWEB::class, 'login']);

Route::resource('users', UserController::class);
Route::get('/devices/analytics/monitor', [EnergyAnalyticsController::class, 'monitor'])->name('devices.monitor');
Route::get('/devices/analytics/{id}', [EnergyAnalyticsController::class, 'show'])->name('devices.analytic.show');
Route::get('/devices/analytics/{id}/consumption', [EnergyAnalyticsController::class, 'getConsumption']);
Route::get('/devices/analytics/{id}/prediction', [EnergyAnalyticsController::class, 'getPrediction']);
Route::resource('/devices/analytics/monitor', EnergyAnalyticsController::class);

// Route::get('/devices/monitor/{id}', [EnergyAnalyticsController,'index'])->name('devices.monitor');
Route::patch('/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
Route::patch('/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
Route::patch('/{device}/activate', [UserController::class, 'activate'])->name('devices.activate');
Route::patch('/{device}/deactivate', [UserController::class, 'deactivate'])->name('devices.deactivate');
Route::post('/monitoring', [BrokerController::class, 'store']);
Route::get('/monitoring', [BrokerController::class, 'index'])->name('devices.monitoring');
Route::get('/monitoring/energy', [MonitoringController::class, 'index'])->name('monitoring.index');

Route::resource('devices', DeviceController::class);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
    ])->group(function () {
    // Route::get('/dashboard', [DashboardController::class,"index"])->name('dashboard');
});

