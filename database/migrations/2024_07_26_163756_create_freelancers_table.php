<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('freelancers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rg');
            $table->string('cpf')->unique();
            $table->date('nascimento');
            $table->string('pai')->nullable();
            $table->string('mae');
            $table->string('placa')->unique();
            $table->string('cnh')->unique();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->string('return_status')->default('Em análise');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancers');
    }
};
