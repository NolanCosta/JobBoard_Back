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
        Schema::create('follow_advertisements', function (Blueprint $table) {
            $table->id();
            $table->text('email_sent');
            $table->string('lastname');
            $table->string('firstname');
            $table->string('email');
            $table->string('phone');
            $table->text('message');
            $table->enum('status', ['SENT', 'ACCEPTED', 'REFUSED'])->default('SENT');;
            $table->foreignId('user_id')
            ->nullable()
            ->onDelete('cascade');
            $table->foreignId('advertisement_id')
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
        Schema::dropIfExists('follow_advertisements');
    }
};
