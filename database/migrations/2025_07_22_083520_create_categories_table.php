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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        DB::table('categories')->insert([
            ['name' => 'Laptop / PC'],
            ['name' => 'Monitor'],
            ['name' => 'Mouse'],
            ['name' => 'Headphones'],
            ['name' => 'Keyboard'],
            ['name' => 'Equipment'],
            ['name' => 'Gift'],
            ['name' => 'Furniture'],
            ['name' => 'Others'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
