<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->year('batch_year');
            $table->string('class');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('nisn')->unique();
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->enum('status', ['active', 'graduated', 'dropped']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
}
