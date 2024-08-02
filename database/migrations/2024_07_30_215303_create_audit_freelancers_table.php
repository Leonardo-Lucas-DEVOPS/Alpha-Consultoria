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
        Schema::create('audit_freelancers', function (Blueprint $table) {
            $table->id();
            $table->string('OldName')->nullable();
            $table->string('OldRg')->nullable();
            $table->string('OldCpf')->nullable();
            $table->date('OldNascimento')->nullable();
            $table->string('OldPai')->nullable();
            $table->string('OldMae')->nullable();
            $table->string('OldCnh')->nullable();
            $table->string('OldPlaca')->nullable();
            $table->string('OldUser_id')->nullable();$table->foreignId('freelancer_id')->nullable()->constrained('freelancers')->onDelete('cascade');//id do Consultor
            $table->string('OldReturn_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_freelancers');
    }
};
