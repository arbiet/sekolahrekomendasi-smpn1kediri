<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentFinalScoresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_final_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->decimal('mathematics', 5, 2);
            $table->decimal('science', 5, 2);
            $table->decimal('english', 5, 2);
            $table->decimal('indonesian', 5, 2);
            $table->decimal('civics', 5, 2);
            $table->decimal('religion', 5, 2);
            $table->decimal('physical_education', 5, 2);
            $table->decimal('arts_and_crafts', 5, 2);
            $table->decimal('local_content', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_final_scores');
    }
}
