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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile');
            $table->string('address');
            $table->string('image')->nullable();
            $table->date('date');
            $table->enum('gender' , ['Male' , 'Female']);
            $table->enum('status' , ['Active' , 'Inactive']);

            // $table->foreignId('city_id');
            // $table->foreign('city_id')->on('cities')->references('id')->cascadeOnDelete();

            $table->morphs('actor');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};