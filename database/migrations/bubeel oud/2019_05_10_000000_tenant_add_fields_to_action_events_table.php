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
        Schema::table('action_events', function (Blueprint $table) {
            $table->text('original')->nullable();
            $table->text('changes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('action_events', function (Blueprint $table) {
            $table->dropColumn('original', 'changes');
        });
    }
};
