<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->string('specification')->nullable(false);
            $table->string('nrg_serial_number')->unique();
            $table->string('product_serial_number')->unique();
            // $table->enum('category', ['Laptop', 'Monitor', 'Mouse', 'Keyboard', 'Others']);
            $table->foreignId('category_id')->after('product_serial_number')->constrained()->onDelete('cascade');
            $table->enum('handling_type', ['Returnable', 'Non-returnable', 'Consumable']);
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade');
            $table->date('procurement_date');
            $table->enum('status', ['Unassigned', 'Assigned', 'Returned to vendor'])->default('Unassigned');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->enum('category', ['Laptop', 'Monitor', 'Mouse', 'Keyboard', 'Others']);
        });
    }
};
