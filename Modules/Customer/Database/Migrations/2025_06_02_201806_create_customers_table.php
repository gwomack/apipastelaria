<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('soft_delete');
            $table->id();
            $table->string('nome')->index();
            $table->string('email')->unique()->index();
            $table->string('telefone')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('endereco')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cep')->nullable();
            $table->timestamp('data_cadastro')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
