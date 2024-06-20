<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/usersignup',[Controller::class , 'UserSignUp'] )->name('UserSignUp');
Route::post('/userlogin',[Controller::class , 'UserLogIn'] )->name('UserLogIn');
Route::post('/google',[Controller::class , 'googlecreds'] )->name('google');
Route::get('/failed',[Controller::class , 'failed'] )->name('failed');
Route::middleware('auth:api')->get('/test',[Controller::class , 'test'] )->name('test');
Route::middleware('auth:api')->get('/test',[Controller::class , 'test'] )->name('test');

Route::middleware('auth:api')->get('/userinformation',[Controller::class , 'userinformation'] )->name('userinformation');
Route::middleware('auth:api')->post('/savemessage',[Controller::class , 'savemessage'] )->name('savemessage');
Route::middleware('auth:api')->post('/getconversation',[Controller::class , 'getconversation'] )->name('getconversation');
Route::middleware('auth:api')->post('/deleteconversation',[Controller::class , 'deleteconversation'] )->name('deleteconversation');

Route::middleware('auth:api')->post('/changename',[Controller::class , 'changename'] )->name('changename');
Route::middleware('auth:api')->post('/changedob',[Controller::class , 'changedob'] )->name('changedob');
Route::middleware('auth:api')->post('/changeemail',[Controller::class , 'changeemail'] )->name('changeemail');
Route::middleware('auth:api')->post('/changepronouns',[Controller::class , 'changepronouns'] )->name('changepronouns');
Route::middleware('auth:api')->post('/changepassword',[Controller::class , 'changepassword'] )->name('changepassword');

Route::post('/reqforgetpassword',[Controller::class , 'reqforgetpassword'] )->name('reqforgetpassword');
Route::post('/logsubscription',[Controller::class , 'logsubscription'] )->name('logsubscription');

Route::post('/resendverify',[Controller::class , 'resendverify'] )->name('resendverify');

Route::middleware('auth:api')->get('/stripelink',[Controller::class , 'stripelink'] )->name('stripelink');
Route::post('/UserAutoCharged',[Controller::class , 'UserAutoCharged'] )->name('UserAutoCharged');
Route::post('/testcheck',[Controller::class , 'testcheck'] )->name('testcheck');

Route::middleware('auth:api')->get('/subscriptionend',[Controller::class , 'subscriptionend'] )->name('subscriptionend');

Route::post('/devsub',[Controller::class , 'devsub'] )->name('devsub');


Route::post('/viewcontent',[Controller::class , 'viewcontent'] )->name('viewcontent');
Route::post('/completeregistration',[Controller::class , 'completeregistration'] )->name('completeregistration');
Route::post('/CompletePayment',[Controller::class , 'CompletePayment'] )->name('CompletePayment');
Route::post('/UseFreeVersion',[Controller::class , 'UseFreeVersion'] )->name('UseFreeVersion');

Route::post('/tiktok',[Controller::class , 'tiktok'] )->name('tiktok');;

Route::post('/tiktokaccess',[Controller::class , 'tiktokaccess'] )->name('tiktokaccess');;
