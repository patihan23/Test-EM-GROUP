<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReportsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// หน้าหลัก - รายการกิจกรรม
Route::get('/', [ActivityLogController::class, 'index'])->name('activities.index');

// เส้นทางสำหรับการจัดการบันทึกกิจกรรม
Route::resource('activities', ActivityLogController::class)->except(['index']);

// เส้นทางสำหรับรายงาน
Route::get('/reports/daily', [ActivityLogController::class, 'dailyReport'])->name('reports.daily');
Route::get('/reports/monthly', [ReportsController::class, 'monthly'])->name('reports.monthly');
