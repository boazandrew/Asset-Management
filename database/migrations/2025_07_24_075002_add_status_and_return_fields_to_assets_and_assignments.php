<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            if (!Schema::hasColumn('assets', 'status')) {
                $table->string('status')->default('Unassigned');
            }
            if (!Schema::hasColumn('assets', 'returned_date')) {
                $table->dateTime('returned_date')->nullable();
            }
        });

        Schema::table('asset_assignments', function (Blueprint $table) {
            if (!Schema::hasColumn('asset_assignments', 'returned')) {
                $table->boolean('returned')->default(false);
            }
            if (!Schema::hasColumn('asset_assignments', 'returned_at')) {
                $table->dateTime('returned_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['status', 'returned_date']);
        });

        Schema::table('asset_assignments', function (Blueprint $table) {
            $table->dropColumn(['returned', 'returned_at']);
        });
    }

};
