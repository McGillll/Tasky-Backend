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
        Schema::create('employee_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('taskId');
            $table->unsignedBigInteger('employeeId');

            $table->timestamps();

            $table->foreign('taskId')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('employeeId')->references('id')->on('users');

            $table->primary(['taskId', 'employeeId']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_tasks', function (Blueprint $table) {
            $table->dropForeign(['taskId_id']);
            $table->dropForeign(['employeeId_id']);
        });
        Schema::dropIfExists('employee_tasks');
    }
};
