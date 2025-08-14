<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\TransferTypeController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\ReligionController;


// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::get('/users/create-enhanced', [AdminController::class, 'createUserEnhanced'])->name('users.create-enhanced');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Village Management
    Route::get('/villages', [VillageController::class, 'index'])->name('villages');
    Route::get('/villages/create', [VillageController::class, 'create'])->name('villages.create');
    Route::post('/villages', [VillageController::class, 'store'])->name('villages.store');
    Route::get('/villages/{village}/edit', [VillageController::class, 'edit'])->name('villages.edit');
    Route::put('/villages/{village}', [VillageController::class, 'update'])->name('villages.update');
    Route::delete('/villages/{village}', [VillageController::class, 'destroy'])->name('villages.delete');
    
    // Mutasi Routes
    Route::get('/mutasi', [MutasiController::class, 'index'])->name('mutasi.index');
    Route::get('/mutasi/create', [MutasiController::class, 'create'])->name('mutasi.create');
    Route::post('/mutasi', [MutasiController::class, 'store'])->name('mutasi.store');
    Route::get('/mutasi/{user}/masuk', [MutasiController::class, 'showMutasiMasuk'])->name('mutasi.masuk');
    Route::post('/mutasi/masuk', [MutasiController::class, 'storeMutasiMasuk'])->name('mutasi.masuk.store');
    Route::get('/mutasi/{user}/riwayat', [MutasiController::class, 'showRiwayatMutasi'])->name('mutasi.riwayat');
    Route::post('/mutasi/riwayat', [MutasiController::class, 'storeRiwayatMutasi'])->name('mutasi.riwayat.store');

    // Transfer Management
    Route::get('/transfers', [TransferController::class, 'index'])->name('transfers');
    Route::get('/transfers/create', [TransferController::class, 'create'])->name('transfers.create');
    Route::post('/transfers', [TransferController::class, 'store'])->name('transfers.store');
    Route::get('/transfers/{transfer}', [TransferController::class, 'show'])->name('transfers.show');
    Route::get('/transfers/{transfer}/edit', [TransferController::class, 'edit'])->name('transfers.edit');
    Route::put('/transfers/{transfer}', [TransferController::class, 'update'])->name('transfers.update');
    Route::delete('/transfers/{transfer}', [TransferController::class, 'destroy'])->name('transfers.delete');
    Route::patch('/transfers/{transfer}/status', [TransferController::class, 'updateStatus'])->name('transfers.status');
    
    // Reports Management
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/reports/employees', [ReportsController::class, 'employees'])->name('reports.employees');
    Route::get('/reports/villages', [ReportsController::class, 'villages'])->name('reports.villages');
    Route::get('/reports/transfers', [ReportsController::class, 'transfers'])->name('reports.transfers');
    Route::get('/reports/employees/export', [ReportsController::class, 'exportEmployees'])->name('reports.employees.export');
    
    // System Management
    Route::get('/system', [SystemController::class, 'index'])->name('system');
    Route::get('/system/database', [SystemController::class, 'database'])->name('system.database');
    Route::get('/system/logs', [SystemController::class, 'logs'])->name('system.logs');
    Route::get('/system/maintenance', [SystemController::class, 'maintenance'])->name('system.maintenance');
    Route::get('/system/backup', [SystemController::class, 'backup'])->name('system.backup');
    Route::post('/system/cache/clear', [SystemController::class, 'clearCache'])->name('system.cache.clear');
    Route::post('/system/optimize', [SystemController::class, 'optimize'])->name('system.optimize');
    Route::post('/system/migrate', [SystemController::class, 'migrate'])->name('system.migrate');
    
    // Notification Management
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.delete');
    
    // Education Management
    Route::get('/education', [EducationController::class, 'index'])->name('education.index');
    Route::get('/education/create', [EducationController::class, 'create'])->name('education.create');
    Route::post('/education', [EducationController::class, 'store'])->name('education.store');
    Route::get('/education/{education}/edit', [EducationController::class, 'edit'])->name('education.edit');
    Route::put('/education/{education}', [EducationController::class, 'update'])->name('education.update');
    Route::delete('/education/{education}', [EducationController::class, 'destroy'])->name('education.destroy');
    
    // Transfer Type Management
    Route::get('/transfer-types', [TransferTypeController::class, 'index'])->name('transfer-types.index');
    Route::get('/transfer-types/create', [TransferTypeController::class, 'create'])->name('transfer-types.create');
    Route::post('/transfer-types', [TransferTypeController::class, 'store'])->name('transfer-types.store');
    Route::get('/transfer-types/{transferType}/edit', [TransferTypeController::class, 'edit'])->name('transfer-types.edit');
    Route::put('/transfer-types/{transferType}', [TransferTypeController::class, 'update'])->name('transfer-types.update');
    Route::delete('/transfer-types/{transferType}', [TransferTypeController::class, 'destroy'])->name('transfer-types.destroy');
    
    // Kelola Golongan
    Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
    Route::post('/grades', [GradeController::class, 'store'])->name('grades.store');
    Route::put('/grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
    Route::delete('/grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');
    
    // Kelola Pangkat
    Route::get('/ranks', [RankController::class, 'index'])->name('ranks.index');
    Route::post('/ranks', [RankController::class, 'store'])->name('ranks.store');
    Route::put('/ranks/{rank}', [RankController::class, 'update'])->name('ranks.update');
    Route::delete('/ranks/{rank}', [RankController::class, 'destroy'])->name('ranks.destroy');
    
    // Kelola Agama
    Route::get('/religions', [ReligionController::class, 'index'])->name('religions.index');
    Route::post('/religions', [ReligionController::class, 'store'])->name('religions.store');
    Route::put('/religions/{religion}', [ReligionController::class, 'update'])->name('religions.update');
    Route::delete('/religions/{religion}', [ReligionController::class, 'destroy'])->name('religions.destroy');
});

// User Routes
Route::prefix('user')->name('user.')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    
    // Data Pegawai untuk User
    Route::get('/employees', [UserController::class, 'employees'])->name('employees');
    
    // Data Mutasi untuk User
    Route::get('/transfers', [UserController::class, 'transfers'])->name('transfers');
    
    // User Notification Management
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.delete');
    
    Route::put('/profile/password', [UserController::class, 'changePassword'])->name('profile.password');
});


