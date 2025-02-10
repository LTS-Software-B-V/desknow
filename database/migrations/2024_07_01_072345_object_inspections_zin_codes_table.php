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
        Schema::create('object_inpection_zincodes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('company_id')->nullable()->constrained('companies');

            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
