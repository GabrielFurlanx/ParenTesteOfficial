<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExameSangue extends Model
{
    use HasFactory;

    // Defina o nome da tabela, caso não seja o nome plural do modelo
    protected $table = 'laudos_exame';

    // Defina os campos que podem ser preenchidos via mass assignment
    protected $fillable = [
        'ordem',
        'numero_paciente',
        'data', // Certifique-se de usar 'data' e não 'data_numero_paciente'
        'tipo_teste',
        'resultado',
        'inicio_teste',
        'paciente',
        'sexo',
        'usuario',
        'finalizacao',
    ];

}
