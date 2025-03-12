<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('laudos_exame', function (Blueprint $table) {
            $table->id();
            $table->string('ordem');
            $table->string('numero_paciente');
            $table->string('data'); // Alterado para 'data'
            $table->string('tipo_teste');
            $table->decimal('resultado', 8, 2);
            $table->timestamp('inicio_teste');
            $table->string('paciente')->nullable();
            $table->string('sexo')->nullable();
            $table->string('usuario');
            $table->timestamp('finalizacao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laudos_exame');
    }

};
