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
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('describe_words')->nullable();
            $table->text('interests')->nullable();
            $table->string('food_preference')->nullable();
            $table->string('smoking_habit')->nullable();
            $table->string('drinking_habit')->nullable();
            $table->string('family_type')->nullable();
            $table->string('is_physically_challenged')->nullable();
            $table->string('mangalik')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'describe_words', 'interests', 'food_preference', 
                'smoking_habit', 'drinking_habit', 'family_type', 
                'is_physically_challenged', 'mangalik'
            ]);
        });
    }
};
