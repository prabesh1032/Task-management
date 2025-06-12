<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Task title
            $table->text('description')->nullable(); // Task description
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium'); // Priority level
            $table->date('due_date')->nullable(); // Task due date
            $table->unsignedBigInteger('assigned_to')->nullable(); // User ID of the assigned member
            $table->text('todo_checklist')->nullable(); // Checklist items stored as JSON or text
            $table->string('attachment')->nullable(); // Path to uploaded file
            $table->string('status')->default('pending'); // Status: pending, completed, overdue
            $table->timestamps();

            // Foreign key constraint for assigned_to
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
