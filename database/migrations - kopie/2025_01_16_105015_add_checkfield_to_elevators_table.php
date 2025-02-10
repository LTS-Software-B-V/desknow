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
        Schema::table('elevators', function (Blueprint $table) {
            $table->date('current_inspection_end_date')->nullable();
            $table->integer('current_inspection_status_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('elevators', function (Blueprint $table) {
            //
        });
    }
};
