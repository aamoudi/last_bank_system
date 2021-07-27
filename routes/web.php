<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPermissionController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\IncomeTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::prefix('cms/admin')->middleware('guest:admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('auth.login.view');
    Route::post('login', [AdminAuthController::class, 'login'])->name('auth.login');
});

Route::prefix('cms/user')->middleware('guest:user')->group(function () {
    Route::get('login', [UserAuthController::class, 'showLogin'])->name('auth-user.login.view');
    Route::post('login', [UserAuthController::class, 'login'])->name('auth-user.login');
});

Route::prefix('cms/admin')->middleware('auth:admin,user', 'verified')->group(function () {
    Route::view('', 'cms.dashboard')->name('cms.dashboard');
    Route::resource('users', UserController::class);
});

Route::prefix('cms/admin')->middleware('auth:admin', 'verified')->group(function () {
    Route::resource('cities', CityController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('currencies', CurrencyController::class);
    Route::resource('professions', ProfessionController::class);

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::resource('admins.permissions', AdminPermissionController::class);
    Route::resource('role.permissions', RolePermissionController::class);

    Route::delete('currencies/{id}/restore', [CurrencyController::class, 'restore'])->name('currencies.restore');

    Route::get('edit-password', [AdminAuthController::class, 'editPassword'])->name('auth.edit-password');
    Route::put('update-password', [AdminAuthController::class, 'updatePassword'])->name('auth.update-password');

    Route::get('edit-profile', [AdminAuthController::class, 'editProfile'])->name('auth.edit-profile');
    Route::put('update-profile', [AdminAuthController::class, 'updateProfile'])->name('auth.update-profile');

    Route::get('logout', [AdminAuthController::class, 'logout'])->name('auth.logout');
});

Route::prefix('cms/admin')->middleware('auth:user', 'verified')->group(function () {
    Route::resource('income-types', IncomeTypeController::class);
    Route::resource('expense-types', ExpenseTypeController::class);
    Route::resource('wallets', WalletController::class);
    Route::resource('debits', DebitController::class);
    Route::resource('transaction', TransactionController::class);
    Route::get('/wallettrans', [WalletController::class, 'transaction']);
    // Route::get('edit-password', [AdminAuthController::class, 'editPassword'])->name('auth.edit-password');
    // Route::put('update-password', [AdminAuthController::class, 'updatePassword'])->name('auth.update-password');

    // Route::get('edit-profile', [AdminAuthController::class, 'editProfile'])->name('auth.edit-profile');
    // Route::put('update-profile', [AdminAuthController::class, 'updateProfile'])->name('auth.update-profile');

    Route::get('logout-user', [UserAuthController::class, 'logout'])->name('auth-user.logout');
});

// Route::prefix('cms/admin')->namespace('App\Http\Controllers\Auth')->middleware('guest:admin')->group(function () {
//     Route::get('login', 'AdminAuthController@showLogin')->name('auth.login.view');
//     Route::post('login', 'AdminAuthController@login'])->name('auth.login');
// });

// Route::get('age', function () {
//     return response()->json(['status' => true, 'message' => 'Age is bigger or equal 18']);
// })->middleware(CheckAge::class);

// Route::get('age', function () {
//     return response()->json(['status' => true, 'message' => 'Age is bigger or equal 18']);
// }); // Register Middleware in global web route middlewares

// Route::get('age', function () {
//     return response()->json(['status' => true, 'message' => 'Age is bigger or equal 18']);
// })->middleware('age.check');

// Route::middleware(['age.check:Editor,A,B,C,D'])->group(function () {
//     Route::get('age1', function () {
//         return response()->json(['status' => true, 'message' => 'Age is bigger or equal 18']);
//     });

//     Route::get('age2', function () {
//         return response()->json(['status' => true, 'message' => 'Age is bigger or equal 18']);
//     })->withoutMiddleware('age.check');
// });

Route::get('/email/verify', function () {
    return "YOUR EMAIL IS NOT VERIFIED";
    // return view('auth.verify-email');
})->middleware('auth:admin')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/cms/admin');
})->middleware(['auth:admin', 'signed'])->name('verification.verify');

// Route::get("testemail", function () {
//     return new NewAdminWelcomeEmail();
// });

Route::get('/forgot-password', function () {
    return view('cms.auth.forgot-password');
})->middleware('guest:admin')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    // return $status === Password::RESET_LINK_SENT
    //     ? back()->with(['status' => __($status)])
    //     : back()->withErrors(['email' => __($status)]);

    return $status === Password::RESET_LINK_SENT
        ? __($status)
        : __($status);
})->middleware('guest:admin')->name('password.email');


Route::get('delete-file', function () {
    $isDeleted = Storage::disk('public')->delete('images/professions/abc_profiession_1609807343.png');
    // $isDeleted = Storage::disk('public')->deleteDirectory('images');
    return response()->json(['status' => $isDeleted]);
});

Route::get('storage2', function () {
    $exitCode = Artisan::call('storage:link');
    echo $exitCode;
});
