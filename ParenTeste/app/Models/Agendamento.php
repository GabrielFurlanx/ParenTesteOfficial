<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $table = 'agendamentos'; // Nome da tabela no banco

    protected $fillable = [
        'nome_paciente',
        'telefone',
        'email',
        'data_consulta',
        'hora_consulta',
    ];
}

