<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingOptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventSeriesController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\LandscaperProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PersonalAccessTokenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;
use App\Models\Booking;
use App\Models\BookingOption;
use App\Models\Venue;
use App\Models\ServiceSeries;
use App\Models\Form;
use App\Models\Location;
use App\Models\Organization;
use App\Models\PersonalAccessToken;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;

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

Route::middleware('auth')->group(static function () {
     Route::model('bookings', Booking::class);
     Route::resource('bookings', BookingController::class)
          ->only(['show', 'edit', 'update']);

     Route::resource('events', EventController::class)
          ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
     Route::resource('events/{event:slug}/booking-options', BookingOptionController::class)
          ->only(['show', 'create', 'store', 'edit', 'update']);
     Route::resource('events/{event:slug}/{booking_option:slug}/bookings', BookingController::class)
          ->only(['index']);

     Route::model('event_series', ServiceSeries::class);
     Route::resource('event-series', EventSeriesController::class)
          ->only(['index', 'show', 'create', 'store', 'edit', 'update']);

     Route::model('form', Form::class);
     Route::resource('forms', FormController::class)
          ->only(['index', 'show', 'create', 'store', 'edit', 'update']);

     Route::model('location', Location::class);
     Route::resource('locations', LocationController::class)
          ->only(['index', 'create', 'store', 'edit', 'update']);

     Route::model('organization', Organization::class);
     Route::resource('organizations', OrganizationController::class)
          ->only(['index', 'create', 'store', 'edit', 'update']);

     Route::model('personal_access_token', PersonalAccessToken::class);
     Route::resource('personal-access-tokens', PersonalAccessTokenController::class)
          ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

     Route::model('user', User::class);
     Route::resource('users', UserController::class)
          ->only(['index', 'create', 'store', 'edit', 'update']);

     Route::model('user_role', UserRole::class);
     Route::resource('user-roles', UserRoleController::class)
          ->only(['index', 'create', 'store', 'edit', 'update']);

     // My Account
     Route::get('account', [AccountController::class, 'edit'])
          ->name('account.edit');
     Route::put('account', [AccountController::class, 'update'])
          ->name('account.update');
});

Route::get('/', [DashboardController::class, 'index'])
     ->name('dashboard');
Route::get('/landscaper', [DashboardController::class, 'landscaper_booking'])
     ->name('dashboard.landscaper');
Route::get('/home', [HomeController::class, 'index'])
     ->name('home');
Route::get('/dashboard_bookings', [DashboardController::class, 'booking_index'])
     ->name('dashboard.bookings');
Route::get('/register2', [RegisterController::class, 'showRegistrationForm2'])->name('register2');
Route::post('/register2', [RegisterController::class, 'register2']);


Route::model('event', Venue::class);
Route::resource('events', EventController::class)
     ->only(['show']);

Route::model('booking_option', BookingOption::class);
Route::resource('events/{event:slug}/booking-options', BookingOptionController::class)
     ->only(['show', 'destroy']);

Route::resource('events/{event:slug}/{booking_option:slug}/bookings', BookingController::class)
     ->only(['store']);

Route::post('/reviews', 'App\Http\Controllers\ReviewController@store')->name('reviews.store');

Route::get('/chats/create', [App\Http\Controllers\ChatController::class, 'index'])->name('chats.index');
Route::post('/chats', [App\Http\Controllers\ChatController::class, 'store'])->name('chats.store');
Route::get('/chat/history/{landscaper_id}', [ChatController::class, 'history'])->name('chats.history');

Route::get('/landscaper_profile', [LandscaperProfileController::class, 'index'])->name('landscaper_profile.index');

Route::get('/chat_center', [ChatController::class, 'index'])->name('chat.center');
Route::get('/chat_landscaper', [ChatController::class, 'chat_landscaper'])->name('chat.landscaper');

Route::get('/reports', [DashboardController::class, 'landscaper_report'])->name('dashboard.landscaper_report');

// Payment
Route::get('payment/{booking}', [PaymentController::class, 'index'])->name('payment.index');
Route::post('payment/{booking}', [PaymentController::class, 'process'])->name('payment.process');

// wishlist
Route::middleware('auth')->group(function () {
     Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
     Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
     Route::delete('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
});




require __DIR__ . '/auth.php';