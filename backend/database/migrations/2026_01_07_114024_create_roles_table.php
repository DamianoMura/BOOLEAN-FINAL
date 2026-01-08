<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->timestamps();
        });

        DB::table('roles')->insert([
            ['name' => 'dev', 'label' => 'Developer'],
            ['name' => 'admin', 'label' => 'Administrator'],
            ['name' => 'user', 'label' => 'Basic User'],
            ['name' => 'nau', 'label' => 'User awaiting for approval from Dev'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
