<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ExameSangue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ExameController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Dados recebidos:', $request->all()); // Exibe no terminal

        $validatedData = $request->validate([
            'ordem' => 'required|string',
            'numero_paciente' => 'required|integer',
            'data' => 'required|string', // Alterado para 'data'
            'tipo_teste' => 'required|string',
            'resultado' => 'required|numeric',
            'inicio_teste' => 'required|date',
            'paciente' => 'nullable|string',
            'sexo' => 'nullable|string',
            'usuario' => 'required|string',
            'finalizacao' => 'nullable|date',
        ]);

        $exame = ExameSangue::create($validatedData);

        return response()->json(['message' => 'Exame salvo com sucesso!', 'data' => $exame], 201);
    }


    public function laudos()
    {
        $laudos = ExameSangue::all(); // Buscando todos os exames
        return Inertia::render('HistoricoLaudos', [
            'dados' => $laudos, // Enviando para o Vue
        ]);
    }
    /*
    public function index()
    {
        // Exibe a tela inicial com o botão
        return Inertia::render('Exame');
    }

    public function laudos()
    {
        // Puxa os dados do banco e retorna via Inertia
        $exames = ExameSangue::all();
        return Inertia::render('HistoricoLaudos', ['dados' => $exames]);  // Use 'HistoricoLaudos' aqui
    }

    */

}
