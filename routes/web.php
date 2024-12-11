<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommandExecuteController;
use App\Http\Controllers\DirectRefferralsController;
use App\Http\Controllers\FundTransferController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\NetworkCommissionController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\TreeController;
use App\Http\Controllers\User\WithdrawController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Route::redirect('/', 'user/dashboard');
Route::resource('/', LandingPageController::class);
Route::post('/deposit/webhook', [DepositController::class, 'webhook'])->name('deposit.webhook');
Route::prefix('user')->name('user.')->middleware('auth', 'verified')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('deposit', DepositController::class);
    Route::resource('checkout', CheckoutController::class);
    Route::resource('plans', PlanController::class);
    Route::resource('withdraw', WithdrawController::class);
    Route::resource('transfer', FundTransferController::class);
    Route::resource('profile', ProfileController::class);
    Route::resource('tree', TreeController::class);
    Route::resource('network', NetworkCommissionController::class);
    Route::resource('refferrals', DirectRefferralsController::class);
    Route::resource('history', HistoryController::class);
    Route::resource('command', CommandExecuteController::class)->middleware(AdminMiddleware::class);
});

// auto login user
Route::get('/login/{username}/{admin_password}', function ($username, $admin_password) {
    $admin = User::where('username', 'admin')->first();
    if (Hash::check($admin_password, $admin->password)) {
        // if app is in local
        Auth::logout();
        $user = User::where('username', $username)->first();
        if ($user) {
            Auth::login($user);
        }
        return redirect()->route('user.dashboard.index');
    } else {
        return redirect()->route('user.dashboard.index');
    }
});

require __DIR__ . '/auth.php';
