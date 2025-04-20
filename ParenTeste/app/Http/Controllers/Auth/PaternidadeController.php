<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Paternidade;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaternidadeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nome_crianca' => 'required|string|max:255',
            'certidao_crianca' => 'nullable|string|max:255',
            'cpf_crianca' => 'nullable|string|max:14',
            'nome_mae' => 'required|string|max:255',
            'rg_mae' => 'nullable|string|max:20',
            'cpf_mae' => 'nullable|string|max:14',
            'nome_investigado' => 'required|string|max:255',
            'rg_investigado' => 'nullable|string|max:20',
            'cpf_investigado' => 'nullable|string|max:14',
            'data_exame' => 'required|date',
            'ip_acumulado' => 'required|numeric|min:0',
            'probabilidade_paternidade' => 'required|numeric|min:0|max:100',
            'dados_exame' => 'required|array',
        ]);

        $paternidade = Paternidade::create($request->all());

        return response()->json($paternidade, 201);
    }

    public function laudos()
    {
        $laudos = Paternidade::all(); // Buscando todos os exames
        return Inertia::render('HistoricoPaternidade', [
            'dados' => $laudos, // Enviando para o Vue
        ]);
    }


    public function index()
    {
        return response()->json(Paternidade::all());
    }

    public function show($id)
    {
        return response()->json(Paternidade::findOrFail($id));
    }
}
