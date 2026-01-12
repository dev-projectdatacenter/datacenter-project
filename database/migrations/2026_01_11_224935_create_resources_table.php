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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('resource_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('status')->default('available'); // available / busy / maintenance
            $table->string('cpu')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->string('os')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
