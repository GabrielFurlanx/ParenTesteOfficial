<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('paternidade_exame', function (Blueprint $table) {
            $table->id();
            $table->string('nome_crianca', 255);
            $table->string('certidao_crianca', 255)->nullable();
            $table->string('cpf_crianca', 14)->nullable();
            $table->string('nome_mae', 255);
            $table->string('rg_mae', 20)->nullable();
            $table->string('cpf_mae', 14)->nullable();
            $table->string('nome_investigado', 255);
            $table->string('rg_investigado', 20)->nullable();
            $table->string('cpf_investigado', 14)->nullable();
            $table->date('data_exame');
            $table->decimal('ip_acumulado', 10, 2)->default(0);
            $table->decimal('probabilidade_paternidade', 5, 2)->default(0);
            $table->json('dados_exame'); // Salva os inputs e índices da tabela em JSON
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paternidade_exame');
    }
};
