<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LandlordController;
use App\Http\Controllers\Api\RegistrationController;

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
    Route::get('/noaccess', [AdminController::class, 'noaccess'])->name('admin.noaccess');

    Route::group(['middleware' => ['AdminAuth']], function () {

        /************** PAGE ROUTES ******************/
        Route::group(['middleware' => ['check.subadmin.access']], function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('check.subadmin.access:true');
            Route::get('/admin_user', [AdminController::class, 'adminUser'])->name('admin.admin_user');
            Route::get('/subscription', [AdminController::class, 'subscription'])->name('admin.subscription');
            Route::get('/landlord', [AdminController::class, 'landlord'])->name('admin.landlord');
            Route::get('/tenant', [AdminController::class, 'tenant'])->name('admin.tenant');
            Route::get('/api_settings', [AdminController::class, 'apiSettings'])->name('admin.api_settings');

        });
        
        /************** AJAX ROUTES ******************/
        Route::post('/editSpecificPlan', [AdminController::class, 'editSpecificPlan'])->name('admin.editSpecificPlan');
        Route::post('/savePlanDetail', [AdminController::class, 'savePlanDetail'])->name('admin.savePlanDetail');

        Route::get('/getAdminUserList', [AdminController::class, 'get_admin_users_list'])->name('admin.getAdminUserList');
        Route::post('/deleteUser', [AdminController::class, 'delete_user'])->name('admin.deleteUser');
        Route::post('/changestatus', [AdminController::class, 'change_status'])->name('admin.changestatus');
        Route::post('/getuserdata', [AdminController::class, 'get_user_data'])->name('admin.getuserdata');
        Route::post('/updateUser', [AdminController::class, 'update_user'])->name('admin.updateUser');
        Route::post('/addUser', [AdminController::class, 'add_user'])->name('admin.addUser');
        
        Route::post('/getLandlordPageData', [AdminController::class, 'get_landlord_data'])->name('admin.getLandlordPageData');
        Route::post('/changeStatusLandlord', [AdminController::class, 'change_status_landlord'])->name('admin.changeStatusLandlord');
        Route::post('/getSpecificLandlordDetail', [AdminController::class, 'get_specific_landlord'])->name('admin.getSpecificLandlordDetail');
        Route::post('/deleteLandlord', [AdminController::class, 'delete_landlord'])->name('admin.deleteLandlord');
        
        Route::post('/getTenantPageData', [AdminController::class, 'get_tenant_data'])->name('admin.getTenantPageData');
        Route::post('/changeStatusTenant', [AdminController::class, 'change_status_tenant'])->name('admin.changeStatusTenant');
        Route::post('/getSpecificTenantDetail', [AdminController::class, 'get_specific_tenant'])->name('admin.getSpecificTenantDetail');
        Route::post('/deleteTenant', [AdminController::class, 'delete_tenant'])->name('admin.deleteTenant');
        
        Route::post('/saveApiSettings', [AdminController::class, 'save_api_settings'])->name('admin.saveApiSettings');

        

    });
});

// customer routes start 
Route::group(['prefix' => 'customer'], function () {
    
    Route::get('/', [CustomerController::class, 'login'])->name('/');
    Route::get('/login', [CustomerController::class, 'login'])->name('customer.login');
        Route::post('/loginSubmit', [CustomerController::class, 'loginSubmit'])->name('customer.loginSubmit');
        Route::get('/logout', [CustomerController::class, 'logout'])->name('customer.logout');
        Route::get('/noaccess', [CustomerController::class, 'noaccess'])->name('customer.noaccess');
        Route::get('/forgotpassword', [CustomerController::class, 'forgotpassword'])->name('customer.forgotpassword');
        
        
        
        
        
        
        Route::post('/forgetpasswordemailvalidate', [CustomerController::class, 'forgot_password_validate_email'])->name('customer.forgetpasswordemailvalidate');
        Route::post('/verifyotp', [CustomerController::class, 'verify_otp'])->name('customer.verifyotp');
        Route::post('/resetpassword', [CustomerController::class, 'reset_password'])->name('customer.resetpassword');


        Route::group(['middleware' => ['UserAuth']], function () {
            
            
        /************** PAGE ROUTES ******************/
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
            
            
            

            
            
            
         /************** AJAX ROUTES ******************/

            
            
            
            

});
});
