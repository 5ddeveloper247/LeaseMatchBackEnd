<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LandlordController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\PaymentController;

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
    return redirect('/customer/login'); // view('welcome');
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
            Route::get('/user_payments', [AdminController::class, 'userPayments'])->name('admin.user_payments');
            Route::get('/user_subscriptions', [AdminController::class, 'userSubscriptions'])->name('admin.user_subscriptions');
            Route::get('/contact_us', [AdminController::class, 'contactUs'])->name('admin.contact_us');
            Route::get('/my_account', [AdminController::class, 'my_account'])->name('admin.my_account');

            Route::get('/property_matches', [AdminController::class, 'propertyMatches'])->name('admin.property_matches');
            // Route::get('/enquiry_process', [AdminController::class, 'enquiryProcess'])->name('admin.enquiry_process');
            Route::get('/required_documents', [AdminController::class, 'required_documents'])->name('admin.required_documents');
            Route::get('/enquiry_requests', [AdminController::class, 'enquiry_requests'])->name('admin.enquiry_requests');
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

        Route::post('/getPaymentsPageData', [AdminController::class, 'get_payment_data'])->name('admin.getPaymentsPageData');
        Route::post('/getPaymentListWrtUser', [AdminController::class, 'get_payment_list_user'])->name('admin.getPaymentListWrtUser');

        Route::post('/getSubscriptionsPageData', [AdminController::class, 'get_subscriptions_data'])->name('admin.getSubscriptionsPageData');
        Route::post('/getSubscriptionsListWrtUser', [AdminController::class, 'get_subscriptions_list_user'])->name('admin.getSubscriptionsListWrtUser');

        Route::post('/getContactUsPageData', [AdminController::class, 'get_contactus_page_data'])->name('admin.getContactUsPageData');
        Route::post('/getSpecificContactUsDetail', [AdminController::class, 'get_specific_contactus_detail'])->name('admin.getSpecificContactUsDetail');
        Route::post('/saveContactReply', [AdminController::class, 'save_contact_reply'])->name('admin.saveContactReply');

        Route::get('/getprofiledata', [AdminController::class, 'get_profile_data'])->name('admin.getprofiledata');
        Route::post('/updateprofile', [AdminController::class, 'update_profile'])->name('admin.updateprofile');

        Route::post('/getEnquiryPageData', [AdminController::class, 'enquiry_page_data'])->name('admin.getEnquiryPageData');
        Route::get('/getrequired_documentsPageData', [AdminController::class, 'required_documentsPageData'])->name('admin.getrequired_documentsPageData');
        Route::post('/add_new_required_document', [AdminController::class, 'add_new_required_document'])->name('admin.add_new_required_document');
        Route::post('/changeRequiredDocumentStatus', [AdminController::class, 'changeRequiredDocumentStatus'])->name('admin.changeRequiredDocumentStatus');
        Route::post('/deleteRequiredDocument', [AdminController::class, 'deleteRequiredDocument'])->name('admin.deleteRequiredDocument');
        Route::post('/getRequiredDocumentDetails', [AdminController::class, 'getRequiredDocumentDetails'])->name('admin.getRequiredDocumentDetails');
        Route::post('/updateRequiredDocument', [AdminController::class, 'updateRequiredDocument'])->name('admin.updateRequiredDocument');

        Route::post('/getMatchesPageData', [AdminController::class, 'get_matches_data'])->name('admin.getMatchesPageData');

        Route::post('/getMatchesListWrtUser', [AdminController::class, 'get_matches_list_user'])->name('admin.getMatchesListWrtUser');
        Route::post('/assignLandlordToUser', [AdminController::class, 'assign_landlord_user'])->name('admin.assignLandlordToUser');
        Route::post('/searchLandlordListingAssign', [AdminController::class, 'search_landlord_assign_listing'])->name('admin.searchLandlordListingAssign');
        Route::post('/removeAssignedPropertyUser', [AdminController::class, 'remove_assigned_property_user'])->name('admin.removeAssignedPropertyUser');

        Route::post('/getEnquiriesPageData', [AdminController::class, 'get_enquiries_data'])->name('admin.getEnquiriesPageData');
        Route::post('/getEnquiryLandlordDetail', [AdminController::class, 'get_specific_enquiry'])->name('admin.getEnquiryLandlordDetail');
        Route::post('/changeEnquiryStatusConfirmed', [AdminController::class, 'change_enquiry_status_confirmed'])->name('admin.changeEnquiryStatusConfirmed');
        Route::post('/changeEnquiryStatusReqDoc', [AdminController::class, 'change_enquiry_status_req_doc'])->name('admin.changeEnquiryStatusReqDoc');
        Route::post('/viewEnquiryDocs', [AdminController::class, 'view_enquiry_docs'])->name('admin.viewEnquiryDocs');
        Route::post('/changeEnquiryStatus', [AdminController::class, 'change_enquiry_status'])->name('admin.changeEnquiryStatus');

        Route::post('/readAllNotifications', [AdminController::class, 'readAllNotifications'])->name('admin.readAllNotifications');
        Route::post('/getDashboardPageData', [AdminController::class, 'get_dashboard_page_data'])->name('admin.getDashboardPageData');

        Route::post('/searchLandlordListing', [AdminController::class, 'search_landlord_listing'])->name('admin.searchLandlordListing');
        Route::post('/searchTenantListing', [AdminController::class, 'search_tenant_listing'])->name('admin.searchTenantListing');
        Route::post('/searchEnquiryListing', [AdminController::class, 'search_enquiry_listing'])->name('admin.searchEnquiryListing');
        Route::post('/account/profile', [AdminController::class, 'admin_account_profile'])->name('admin_account_profile');
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
        Route::get('/mySubscription', [CustomerController::class, 'my_subscription'])->name('customer.mySubscription');
        Route::get('/myAccount', [CustomerController::class, 'my_account'])->name('customer.account_info');
        Route::get('/propertyInformation', [CustomerController::class, 'property_info'])->name('customer.property_info');
        Route::get('/myMatches', [CustomerController::class, 'my_matches'])->name('customer.myMatches');
        Route::any('/propertyDetail', [CustomerController::class, 'property_detail'])->name('customer.propertyDetail');

        /************** PAYMENT ROUTES ******************/
        Route::post('/subscribe', [PaymentController::class, 'processSubscription'])->name('subscribe.process');
        Route::get('/subscription-success', [PaymentController::class, 'subscriptionSuccess'])->name('subscribe.success');
        Route::get('/subscription-error', [PaymentController::class, 'subscriptionError'])->name('subscribe.error');

        /************** AJAX ROUTES ******************/
        Route::get('/getSpecificTenantDetail', [CustomerController::class, 'get_specific_tenant'])->name('customer.getSpecificTenantDetail');
        Route::get('/getprofiledata', [CustomerController::class, 'get_profiledata'])->name('customer.getprofiledata');
        Route::post('/updateprofile', [CustomerController::class, 'update_profile'])->name('customer.updateprofile');
        Route::post('/updatepersonaldata', [CustomerController::class, 'update_personal_data'])->name('customer.updatepersonaldata');
        Route::post('/viewContactInfo', [CustomerController::class, 'view_contact_info'])->name('customer.viewContactInfo');
        Route::post('/processAppRequest', [CustomerController::class, 'process_app_request'])->name('customer.processAppRequest');
        Route::post('/uploadTenantEnquiryDocuments', [CustomerController::class, 'uploadTenantEnquiryDocuments'])->name('customer.uploadTenantEnquiryDocuments');

        Route::post('/readAllNotifications', [CustomerController::class, 'readAllNotifications'])->name('customer.readAllNotifications');
        Route::post('/account/profile', [CustomerController::class, 'customer_account_profile'])->name('customer_account_profile');
    });
});
