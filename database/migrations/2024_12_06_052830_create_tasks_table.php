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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('title');
            $table->string('description');
            $table->date('deadline');
            $table->unsignedBigInteger('creator');
            $table->enum('status', ['Pending', 'Completed']);
            $table->enum('active', ['true', 'false']);
            $table->timestamps();

            $table->foreign('creator')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['creator_id']);
        });
        Schema::dropIfExists('tasks'); }
};
