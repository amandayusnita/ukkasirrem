<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->enum('level', ['admin','kasir'])->default('kasir');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert([
            ['name' => 'admin', 'username' => 'admin', 'password' => Hash::make('123456'), 'level' => 'admin'],
            ['name' => 'kasir', 'username' => 'kasir', 'password' => Hash::make('12345678'), 'level' => 'kasir'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
