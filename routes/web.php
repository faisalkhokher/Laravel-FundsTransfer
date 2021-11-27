<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
| routes are loaded by the RouteServiceProvider within a group which
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');


Route::get('/privacy-policy', function () {
    return view('privacy_policy');
});

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::prefix('admin')->group(function () {
    Route::group(['middleware' => ['auth', 'role:admin']], function () {
        Route::get('/', 'Admin\AdminController@index')->name('dashboard');
        Route::resource('permissions', 'Admin\PermissionController');
        Route::resource('roles', 'Admin\RoleController');
        Route::resource('users', 'Admin\UserController');
        Route::resource('funds', 'Admin\FundController');
        Route::resource('lynloan', 'Admin\LyndrixController');
        // Profile
        Route::get('profile', 'Admin\ProfileController@index')->name('admin.profile');
        Route::post('edit/profile', 'Admin\ProfileController@edit_profile')->name('admin.edit.profile');
        Route::post('edit/password', 'Admin\ProfileController@edit_password')->name('admin.edit.password');

        Route::get('fetch/transactions/{id}', 'Admin\TransactionController@FetchTransections')->name('fetch.transections');
        Route::get('payment', 'Api\Plaid\PlaidController@plaid')->name('admin.plaid');
        Route::post('plaid/redirect', 'Api\Plaid\PlaidController@redirect')->name('plaid-redirect');
    });
});
Route::get('payment', 'Api\Plaid\PlaidController@payment');


Route::post('signup', 'Auth\RegisterController@signup')->name('signup');

Route::prefix('lyndrx')->group(function () {
    Route::group(['middleware' => ['auth', 'role:lyndrx', 'verified']], function () {
        Route::get('/', 'Lyndrix\LyndrixController@index')->name('lyndrx.dashboard');
        Route::resource('loan_tracker', 'Lyndrix\LoanTrackerController');
        Route::resource('explore_page', 'Lyndrix\ExplorePageController');
        Route::resource('direct_loan', 'Lyndrix\DirectLoanController');
        Route::resource('information', 'Lyndrix\InformationController');
        Route::resource('notification', 'Lyndrix\NotificationController');
        Route::get('profile', 'Lyndrix\ProfileController@index')->name('lyndrx.profile');
        Route::get('change/role', 'Lyndrix\ProfileController@changeRole')->name('lyndrx.change.role');
        Route::post('edit/profile', 'Lyndrix\ProfileController@edit_profile')->name('lyndrx.edit.profile');
        Route::post('edit/password', 'Lyndrix\ProfileController@edit_password')->name('lyndrx.edit.password');
        Route::resource('contact_us', 'Lyndrix\ContactUsController');
        Route::post('decline_loan_lyn/{id}', 'Lyndrix\DirectLoanController@declineLoanRequestByLyn')->name('lyndrx.decline.fund');

        // Funds
        Route::get('funds','Lyndrix\FundController@index')->name('lyndrx.funds.index');
        Route::get('withdraw','Lyndrix\FundController@withdraw')->name('lyndrx.funds.withdraw');


    });
});


Route::prefix('x')->group(function () {

    Route::group(['middleware' => ['auth', 'role:x', 'verified']], function () {
        Route::get('/', 'Admin\AdminController@index')->name('x.dashboard');
        Route::resource('loan', 'X\LoanTrackerController');
        Route::resource('request_loan', 'X\RequestLoanController');

        Route::resource('direct_loan', 'X\DirectLoanController');
        Route::resource('information', 'X\InformationController');
        Route::resource('notification', 'X\NotificationController');
        Route::get('profile', 'X\ProfileController@index')->name('x.profile');
        Route::post('edit/profile', 'x\ProfileController@edit_profile')->name('x.edit.profile');
        Route::post('edit/password', 'Lyndrix\ProfileController@edit_password')->name('x.edit.password');
        Route::get('change/role', 'Lyndrix\ProfileController@changeRole')->name('x.change.role');
        Route::resource('contact_us', 'X\ContactUsController');
        Route::get('fund/transfer', 'X\RequestLoanController@fund_transfer')->name('x.fund.transfer');
        Route::get('funds','X\FundController@index')->name('x.funds.index');
        Route::get('withdraw','X\FundController@withdraw')->name('x.funds.withdraw');

    });
});


// Payment Routes
// Step 1. API - create link token (thể tạo API cho app)
Route::post('/create-link-token', 'PaymentController@plaidCreateLinkToken')->name('payment.create-link-token');
// Step 2: show website - link to bank (nếu là API thì truyền APP truyền link_token ở bước 1 cho webview)
// Step 3: Get access token and create Stripe connect account
Route::post('/create-account', 'PaymentController@getAccessTokenAndCreateAccount')->name('payment.create-account');
// Step 4: Success page (Success Connect account)
// NOTE: App sẽ bắt url này ở webview để biết là thành công để xử lý bước tiếp theo ở app
Route::post('/connect-success', 'PaymentController@connectSuccess')->name('payment.connect-success');
// Step 5: API - withdrawal
Route::post('/withdrawal', 'PaymentController@withdrawal')->name('payment.withdrawal');
Route::Post('/charge', 'PaymentController@charge')->name('payment.charge');
