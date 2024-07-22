<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

//ALL Listings
Route::get('/', [ListingController::class, 'index']);

//Show Create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//store listing data from creating Form
Route::post('/listings', [ListingController::class, 'store']);

//show Edit listing form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Update Editted Form
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Manage Listing
Route::get('/listings/manage', [ListingController::class, 'manageListing'])->middleware('auth');

//Single Listings
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//Delete Listing
Route::delete('/listings/{listing}/delete', [ListingController::class, 'destroy'])->middleware('auth');

//Admin approve listing
Route::put('/listings/{listing}/approve', [ListingController::class, 'approveListing'])->middleware('auth');

//REGISTER ROUTES
//show register create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//save registered data
Route::post('/users', [UserController::class, 'store']);

//show Edit user form
Route::get('/user/edit', [UserController::class, 'edit'])->middleware('auth');

//verify email
Route::get('/verify-email/{otp}', [UserController::class, 'verifyEmail'])->name('verify.email');

//resend verificaion otp
Route::get('/user/resend-verify-email', [UserController::class, 'resendVerifyEmailOtp']);

//log user out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//LOGIN ROUTES
//show login create form
Route::get('/login', [UserController::class, 'login'])->name('authorization')->middleware('guest');

//Log In User 
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// reset password
Route::put('/user/reset-password', [UserController::class, 'resetPassword'])->middleware('auth');