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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['CDI', 'CDD', 'INTERIM', 'FREELANCE', 'INTERNSHIP', 'APPRENTICESHIP']);
            $table->string('sector');
            $table->text('description');
            $table->string('city');
            $table->enum('status', ['PUBLISHED', 'STANDBY', 'ARCHIVED'])->default('PUBLISHED');
            $table->foreignId('company_id')
            ->constrained()
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
