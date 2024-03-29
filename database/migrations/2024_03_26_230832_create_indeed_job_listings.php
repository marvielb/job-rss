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
        Schema::create('indeed_job_listings', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->text('title');
            $table->string('employer');
            $table->string('location');
            $table->text('posting_link');
            $table->timestamps();
        });

        Schema::create('indeed_job_listings_tags', function (Blueprint $table) {
            $table->id();
            $table->string('indeed_job_listing_id');
            $table->string('tag');
            $table->timestamps();

            $table->foreign('indeed_job_listing_id')->references('id')->on('indeed_job_listings');
        });

        Schema::create('indeed_job_listings_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('indeed_job_listing_id');
            $table->string('description');
            $table->timestamps();

            $table->foreign('indeed_job_listing_id')->references('id')->on('indeed_job_listings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indeed_job_listings');
        Schema::dropIfExists('indeed_job_listings_tags');
        Schema::dropIfExists('indeed_job_listings_descriptions');
    }
};
