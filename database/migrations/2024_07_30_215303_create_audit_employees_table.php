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
        Schema::create('audit_employees', function (Blueprint $table) {
            $table->id();
            $table->string('OldName')->nullable();
            $table->string('OldRg')->nullable();
            $table->string('OldCpf')->nullable();
            $table->date('OldNascimento')->nullable();
            $table->string('OldPai')->nullable();
            $table->string('OldMae')->nullable();
            $table->string('OldInvoice_id')->nullable();
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade'); //id do Consultor
            $table->string('OldReturn_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_employees');
    }
};
