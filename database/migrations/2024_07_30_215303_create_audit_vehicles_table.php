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
        Schema::create('audit_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('OldPlaca')->nullable();
            $table->string('OldChassi')->nullable();
            $table->string('OldRenavam')->nullable();
            $table->string('OldInvoice_id')->nullable();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->onDelete('cascade');//id do Consultor
            $table->string('OldReturn_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_vehicles');
    }
};
