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
        Schema::create('project_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('firstName', 100);
            $table->string('lastName', 100);
            $table->string('email', 255);
            $table->string('phone', 30)->nullable();
            $table->string('projectType', 100);
            $table->string('budget', 100)->nullable();
            $table->string('timeline', 100)->nullable();
            $table->string('location', 255)->nullable();
            $table->text('projectDescription');
            $table->string('inspiration', 100)->nullable();
            $table->boolean('newsletter')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_inquiries');
    }
};
