<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->enum('achievement_type', ['academic', 'non-academic']);
            $table->string('activity_name');
            $table->enum('level', ['school', 'district', 'province', 'national', 'international']);
            $table->enum('achievement', ['First Place', 'Second Place', 'Third Place', 'Other']);
            $table->year('achievement_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_achievements');
    }
}
