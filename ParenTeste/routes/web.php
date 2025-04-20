<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\CadastroController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ExameController;
use App\Http\Controllers\Auth\AgendamentoController;
use App\Http\Controllers\Auth\PaternidadeController;
use App\Models\Agendamento;
use Carbon\Carbon;



// Rotas públicas (acessíveis sem login)
Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

Route::get('/cadastro', function () {
    return Inertia::render('Cadastro');
});

Route::post('/cadastro', [CadastroController::class, 'cadastro']);

Route::get('/paternidade-info', function () {
    return Inertia::render('Paternidade_info');
});

Route::get('/historico-paternidade', [PaternidadeController::class, 'laudos']);

Route::get('/historico-laudos', [ExameController::class, 'laudos']);


// Rotas protegidas (só acessa se estiver logado)
Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        $hoje = Carbon::now()->toDateString();
        $consultasHoje = Agendamento::whereDate('data_consulta', $hoje)->get();

        return Inertia::render('Menu', [
            'consultasHoje' => $consultasHoje
        ]);
    });

    Route::get('/calculo', function () {
        return Inertia::render('Paternidade');
    });

    Route::get('/exame', function () {
        return Inertia::render('Exame');
    });

    Route::post('/paternidade', [PaternidadeController::class, 'store']);
    Route::post('/exame', [ExameController::class, 'store']);
    Route::post('/agendar-consulta', [AgendamentoController::class, 'store']);
    Route::get('/consultas-hoje', [ExameController::class, 'listarConsultasHoje']);
});


