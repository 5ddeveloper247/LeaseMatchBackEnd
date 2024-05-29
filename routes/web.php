<?php

use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Route;

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
// try {
//     DB::connection()->getPdo();
//     echo 'Database connection is established!';
// } catch (\Exception $e) {
//     echo 'Could not connect to the database. Please check your configuration.<br>' . $e->getMessage();
// }

Route::get('/', function () {
    return redirect('/admin/login');// view('welcome');
});

Route::group(['prefix' => 'admin'], function () {

    Route::get('/', [AdminController::class, 'login'])->name('/');
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/loginSubmit', [AdminController::class, 'loginSubmit'])->name('admin.loginSubmit');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');


    Route::group(['middleware' => ['AdminAuth']], function () {

        /************** PAGE ROUTES ******************/
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/subscription', [AdminController::class, 'subscription'])->name('admin.subscription');
        
        

        /************** AJAX ROUTES ******************/
        // Route::post('/ajax', [AdminController::class, 'ajax'])->name('admin.ajax');
        
    });
});
