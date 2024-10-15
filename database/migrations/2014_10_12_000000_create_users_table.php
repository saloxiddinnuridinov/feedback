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
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->boolean('is_active')->default(1);
            $table->enum('specialist', ['Sirtqi', 'Masofaviy', 'Kunduzgi', 'All'])->default('All');
            $table->rememberToken();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'Salohiddin',
            'surname' => 'Nuridinov',
            'email' => 'admin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'image' => 'https://media.licdn.com/dms/image/D4D03AQGvWkdxYhB9_w/profile-displayphoto-shrink_200_200/0/1699428712073?e=2147483647&v=beta&t=gZaKokP5REckkdNflyPN9j5taRpyULSGGhZGhwUZJTo',
            'role' => 'admin',
            'specialist' => 'All',
            'created_at' => now(),
            'updated_at' => now()
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
