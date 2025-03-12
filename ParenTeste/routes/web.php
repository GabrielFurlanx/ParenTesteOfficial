<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\CadastroController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ExameController;
use App\Http\Controllers\Auth\AgendamentoController;



/*
Route::get('/teste1', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

*/

require __DIR__.'/auth.php';

// Rota protegida do menu
Route::middleware('auth')->get('/', function () {
    return Inertia::render('Menu');
});

// Rotas de login
Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

// Rota de cadastro
Route::get('/cadastro', function () {
    return Inertia::render('Cadastro');
});

Route::post('/cadastro', [CadastroController::class, 'cadastro']);





// Outra rota protegida
Route::middleware('auth')->get('/calculo', function () {
    return Inertia::render('Paternidade');
});

Route::get('/exame', function () {
    return Inertia::render('Exame');
});


Route::post('/exame', [ExameController::class, 'store']);



Route::post('/agendar-consulta', [AgendamentoController::class, 'store']);



