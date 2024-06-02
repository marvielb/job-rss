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
        Schema::create('onlinejobsph_job_listings', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->dateTime('posting_date');
            $table->string('employer');
            $table->string('salary');
            $table->text('description')->nullable();
            $table->text('short_description');
            $table->string('posting_link');
            $table->integer('rating')->nullable();
            $table->dateTime('rated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onlinejobsph_job_listings');
    }
};
