<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//! Auth Routes

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('edit-profile', 'Api\AuthController@profileEdit');
    Route::post('login', 'Api\AuthController@login');
    Route::post('signup', 'Api\AuthController@signup');
    Route::post('password_change', 'Api\AuthController@change_password');
    Route::post('forgot_password', 'Api\AuthController@forgot_password');
});
Auth::routes(['verify' => true]);
Route::group([
    'middleware' => 'auth:api'
  ], function() {
     Route::get('logout', 'Api\AuthController@logout');
     Route::get('user', 'Api\AuthController@user');
     Route::post('update-role', 'Api\AuthController@updateUserRole');
     Route::post('save-token', 'Api\AuthController@device_token');
    
    

     // Resources Routes
     Route::apiResource('project' , 'Api\Project\ProjectController');
     Route::apiResource('project_type' , 'Api\Project\ProjectTypeController');
     Route::apiResource('project_structure' , 'Api\Project\ProjectStructureController');
     Route::apiResource('project_return' , 'Api\Project\ProjectReturnController');
     Route::resource('project_rating' , 'Api\Project\ProjectRatingController');
     // Extra Routes
     Route::post('project/update/{id}' , 'Api\Project\ProjectController@updateProject');
     // Loans Routes
     Route::resource('/loans', 'Api\Loan\LoanController');
     Route::get('user/loan/history', 'Api\Loan\LoanController@loanHistory');
     // X-Loan API
     Route::post('store/x-loan', 'Api\Xloan\XloanController@storeXLoan');
     Route::get('explore/x-loans', 'Api\Xloan\XloanController@exploreLoans')->name('explore');
     Route::post('add-friend', 'Api\Xloan\XloanController@addFriend');
     Route::get('friend-list', 'Api\Xloan\XloanController@friendList');
     Route::get('lyn-friend_list', 'Api\Xloan\XloanController@lynFriendList');
     Route::post('accept_loan_lyn', 'Api\Xloan\XloanController@acceptLoanRequestByLyn');
     Route::get('uuid-user', 'Api\Xloan\XloanController@uuid_exists');
     Route::post('x-loanhistory', 'Api\Xloan\XloanController@xLoanHistory');
     Route::get('notifications', 'Api\Xloan\XloanController@notificationList');
     Route::post('decline_loan_lyn', 'Api\Xloan\XloanController@declineLoanRequestByLyn');
     Route::post('refund', 'Api\Xloan\XloanController@refund');
     Route::post('edit-xloan', 'Api\Xloan\XloanController@edit_xloan');
     Route::post('pending-request', 'Api\Xloan\XloanController@pending_request');
     Route::post('accept-request', 'Api\Xloan\XloanController@accept_request');
     Route::post('decline-request', 'Api\Xloan\XloanController@decline_request');
     //!new Route

     Route::get('show/request/loan', 'Api\Xloan\XloanController@showRequestLoan');
    //! Stripe
    Route::post('/payment/attach_method' , 'Api\Stripe\StripeController@paymentMethod');
    Route::post('/payment_intent' , 'Api\Stripe\StripeController@paymentIntent');
    Route::post('/update/payment_update' , 'Api\Stripe\StripeController@paymentIntentUpdate');
    Route::get('fetch_methods', 'Api\Stripe\StripeController@fetchCards');

    Route::post('transfer/amount' , 'Api\Xloan\XloanController@transfer');
    // QR
    Route::get('/qr' , 'Api\Plaid\PlaidController@qr');
    Route::post('send-users-mail', 'Api\AuthController@send_users_mail');
    Route::get('promo-code', 'Api\AuthController@promo_code');

     //Plaid Payment

});

  // ! Plaid Payment API 

  Route::get('/fetch-institutions' , 'Api\Plaid\PlaidController@fetchInstitutions');

  // Balance Routes   
  Route::get('/user-balance', 'Api\AuthController@userBalance');
  Route::post('loan/deposit', 'Api\Loan\LoanController@loanDeposit');
  Route::get('/fetch/transections' , 'Api\Loan\LoanController@transaction');

  


  Route::post('send-verified-link', 'Api\AuthController@send_verified_link');



  // Payment Routes
  
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