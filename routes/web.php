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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-design', function () {
    return view('test');
});

// Route temporaire pour éviter l'erreur "logout not defined"
Route::post('/logout', function () {
    return "Déconnexion (Test)";
})->name('logout');

Route::get('/logout', function () {
    return "Déconnexion (Test)";
})->name('logout.get');


Route::get('/test-login', function () {
    return view('test-login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

// routes/web.php

use App\Http\Controllers\AuthController; // Vérifie que c'est bien importé

// Page de demande de compte
Route::get('/demande-compte', [AuthController::class, 'showAccountRequest'])->name('account.request');
Route::post('/demande-compte', [AuthController::class, 'submitAccountRequest'])->name('account.request.submit');