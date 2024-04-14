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
        Schema::create('observations', function (Blueprint $table) {
            $table->id(); 
            $table->string('species'); 
            $table->integer('amount');
            $table->string('age')->nullable();
            $table->string('sex')->nullable();
            $table->string('province');
            $table->string('location')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->date('initial_date')->nullable();
            $table->date('final_date')->nullable();
            $table->string('observer')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observations');
    }
};
