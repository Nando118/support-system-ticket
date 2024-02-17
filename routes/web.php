<?php

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

Route::middleware(['guest'])->group(function () {
    Route::get("/login", [\App\Http\Controllers\Auth\AuthController::class, "loginIndex"])->name("login.index");
    Route::post("/login", [\App\Http\Controllers\Auth\AuthController::class, "loginPost"])->name("login.post");

    Route::get("/register", [\App\Http\Controllers\Auth\AuthController::class, "registerIndex"])->name("register.index");
    Route::post("/register", [\App\Http\Controllers\Auth\AuthController::class, "registerPost"])->name("register.post");

    Route::get("/forgot-password", [\App\Http\Controllers\Auth\AuthController::class, "forgotPasswordRequest"])->name("password.request");
    Route::post("/forgot-password", [\App\Http\Controllers\Auth\AuthController::class, "forgotPasswordEmail"])->name("password.email");
    Route::get("/reset-password/{token}", [\App\Http\Controllers\Auth\AuthController::class, "resetPassword"])->name("password.reset");
    Route::post("/reset-password", [\App\Http\Controllers\Auth\AuthController::class, "resetPasswordUpdate"])->name("password.update");
});

Route::middleware(['auth'])->group(function () {
    Route::post("/logout", [\App\Http\Controllers\Auth\AuthController::class, "logout"])->name("logout");

    Route::get("/", [\App\Http\Controllers\Dashboard\DashboardController::class, "index"])->name("home.index");
    Route::get("/home", [\App\Http\Controllers\Dashboard\DashboardController::class, "index"])->name("home.index");

    Route::get("/tickets", [\App\Http\Controllers\Dashboard\Ticket\TicketController::class, "index"])->name("ticket.index");
    Route::get("/tickets/create", [\App\Http\Controllers\Dashboard\Ticket\TicketController::class, "create"])->name("ticket.create");
    Route::post("/tickets/create", [\App\Http\Controllers\Dashboard\Ticket\TicketController::class, "store"])->name("ticket.store");

    Route::get("/tickets/reply/{id}", [\App\Http\Controllers\Dashboard\Ticket\TicketReplyController::class, "index"])->name("ticket.reply.index");
});
