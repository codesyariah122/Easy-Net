<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\DataCenterController;
use App\Http\Controllers\Api\UserManageController;
use App\Http\Controllers\Api\Product\CategoryController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Product\PackageProductController;
use App\Http\Controllers\Api\Map\CategoryMapController;
use App\Http\Controllers\Api\Map\MapController;
use App\Http\Controllers\Api\Contacts\ContactMessageController;
use App\Http\Controllers\Api\Contacts\ContactCategoryMessage;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\LogLoginUserController;

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
Route::middleware('auth:api')->get('/user', [LoginController::class, 'UserProfile']);

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');

// Contact Message
Route::post('/send-message/{apiKey}', [ContactMessageController::class, 'store']);

// Data Center Api
Route::get('/ip_addr/{apiKey}', [DataCenterController::class, 'ip_addr']);
Route::get('/webdata/{apiKey}', [DataCenterController::class, 'WebData']);
Route::get('/product/{apiKey}', [DataCenterController::class, 'PackageProduct']);
Route::get('/product/detail/{slug}/{apiKey}', [DataCenterController::class, 'DetailPackage']);
Route::post('/check-user-email/{apiKey}', [DataCenterController::class, 'CheckEmailUser']);
Route::get('/active-user-chat/{apiKey}/{id}', [DataCenterController::class, 'ActiveChat']);
Route::get('/coordinates/{apikey}', [DataCenterController::class, 'Coordinate']);
Route::get('/covereges/{apikey}', [DataCenterController::class, 'CoveregeArea']);
Route::get('/locator/{ip}/{apiKey}', [DataCenterController::class, 'IpLocator']);
Route::get('/contact-categories/{apiKey}', [DataCenterController::class, 'CategoryMessage']);

// Weather api
Route::get('/weather-city/{city}/{apiKey}', [DataCenterController::class, 'WeatherCity']);

//Event Broadcast Testing
// Route::get('/test-event/{apiKey}', [DataCenterController::class, 'TestBroadcast']);
// Route::get('/contact-event/{apiKey}', [DataCenterController::class, 'ContactMessage']);
// Route::get('/helo-event', [DataCenterController::class, 'HeloEvent']);


// Aktivasi  User
Route::get('/check-activated/{id}/{apiKey}', [DataCenterController::class, 'CheckBeforeActivated']);
Route::put('/activated/{id}/{apiKey}', [DataCenterController::class, 'UserActivation']);

// Count User Online
Route::get('/count-online/{apiKey}', [DataCenterController::class, 'CountUserLogin']);

// after auth
Route::middleware('auth:api')->resource('/user-manage', UserManageController::class);
Route::middleware('auth:api')->resource('/category-product', CategoryController::class);
Route::middleware('auth:api')->resource('/product', ProductController::class);
Route::middleware('auth:api')->resource('/package-product', PackageProductController::class);
Route::middleware('auth:api')->resource('/map-category', CategoryMapController::class);
Route::middleware('auth:api')->resource('/map', MapController::class);
Route::middleware('auth:api')->resource('/category-message', ContactCategoryMessage::class);
Route::middleware('auth:api')->resource('/notification', NotificationController::class);
Route::middleware('auth:api')->get('/all-notifs', [NotificationController::class, 'AllNotif']);
Route::middleware('auth:api')->resource('/logs', LogLoginUserController::class);