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
            $table->id();
            $table->softDeletes();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->integer('is_active')->default(0);
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->longtext('description')->nullable();
            $table->integer('progress')->nullable()->default(0);
            $table->integer('budget_hours')->nullable();
            $table->integer('budget_costs')->nullable();
            $table->foreignId('customer_id')->references('id')->on('customers');
            $table->string('contact_person_name')->nullable();
            $table->foreignId('status_id')->default(0);
            $table->string('slug')->nullable();
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
