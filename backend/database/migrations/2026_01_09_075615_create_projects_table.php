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
        Schema::create('projects', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('title');
            $table->string('github_url')->nullable();
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->default(1);
            $table->foreignId('author_id')->constrained(); //represents the author which is always an admin 
            $table->longText('description')->nullable();
            $table->boolean('published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
