<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void // Cria a Tabela
    {
        Schema::create('autores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 100); // string(nome da coluna, tamanho máximo);
            $table->string('cidade', 100);
            $table->string('endereco', 100);
            $table->string('bairro', 100);
            $table->string('cep', 20);
            $table->string('email', 100);
            $table->string('telefone', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void // Apaga a tabela
    {
        Schema::dropIfExists('autores');
    }
};
