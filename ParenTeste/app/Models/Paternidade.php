<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paternidade extends Model
{
    use HasFactory;

    protected $table = 'paternidade_exame'; // Nome da tabela no banco de dados

    protected $fillable = [
        'nome_crianca',
        'certidao_crianca',
        'cpf_crianca',
        'nome_mae',
        'rg_mae',
        'cpf_mae',
        'nome_investigado',
        'rg_investigado',
        'cpf_investigado',
        'data_exame',
        'ip_acumulado',
        'probabilidade_paternidade',
        'dados_exame' // Para armazenar os inputs e índices da tabela em JSON
    ];

    protected $casts = [
        'data_exame' => 'date',
        'dados_exame' => 'array' // Converte JSON automaticamente para array no PHP
    ];
}
