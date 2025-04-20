<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agendamento;
use Inertia\Inertia;
use Carbon\Carbon;

class AgendamentoController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados
        $validated = $request->validate([
            'nome_paciente' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
            'data_consulta' => 'required|date|after_or_equal:today',
            'hora_consulta' => 'required',
        ]);

        // Criar o agendamento no banco
        Agendamento::create($validated);

        // Retornar resposta para Vue sem atualizar a página, passando a mensagem de sucesso
        return Inertia::render('Menu', [
            'successMessage' => 'Consulta agendada com sucesso!'
        ]);
    }


public function listarConsultasHoje()
{
    $hoje = Carbon::today()->toDateString();

    $consultasHoje = Agendamento::whereDate('data_consulta', $hoje)->get();

    return response()->json($consultasHoje);
}
}
