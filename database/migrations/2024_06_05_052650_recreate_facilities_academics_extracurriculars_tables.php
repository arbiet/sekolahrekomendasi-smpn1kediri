<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateFacilitiesAcademicsExtracurricularsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Recreate facilities table
        Schema::create('new_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_target_id')->constrained('school_targets')->onDelete('cascade');
            $table->string('facility_name');
            $table->text('facility_description')->nullable();
            $table->timestamps();
        });

        // Recreate academics table
        Schema::create('new_academics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_target_id')->constrained('school_targets')->onDelete('cascade');
            $table->decimal('passing_rate', 5, 2);
            $table->decimal('average_score', 5, 2);
            $table->timestamps();
        });

        // Recreate extracurriculars table
        Schema::create('new_extracurriculars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_target_id')->constrained('school_targets')->onDelete('cascade');
            $table->string('activity_name');
            $table->text('activity_description')->nullable();
            $table->timestamps();
        });

        // Copy data from old tables to new tables
        DB::table('new_facilities')->insert(DB::table('facilities')->get()->toArray());
        DB::table('new_academics')->insert(DB::table('academics')->get()->toArray());
        DB::table('new_extracurriculars')->insert(DB::table('extracurriculars')->get()->toArray());

        // Drop old tables
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('academics');
        Schema::dropIfExists('extracurriculars');

        // Rename new tables to old names
        Schema::rename('new_facilities', 'facilities');
        Schema::rename('new_academics', 'academics');
        Schema::rename('new_extracurriculars', 'extracurriculars');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Recreate old tables
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_school_id')->constrained('target_schools')->onDelete('cascade');
            $table->string('facility_name');
            $table->text('facility_description')->nullable();
            $table->timestamps();
        });

        Schema::create('academics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_school_id')->constrained('target_schools')->onDelete('cascade');
            $table->decimal('passing_rate', 5, 2);
            $table->decimal('average_score', 5, 2);
            $table->timestamps();
        });

        Schema::create('extracurriculars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_school_id')->constrained('target_schools')->onDelete('cascade');
            $table->string('activity_name');
            $table->text('activity_description')->nullable();
            $table->timestamps();
        });

        // Copy data back to old tables
        DB::table('facilities')->insert(DB::table('new_facilities')->get()->toArray());
        DB::table('academics')->insert(DB::table('new_academics')->get()->toArray());
        DB::table('extracurriculars')->insert(DB::table('new_extracurriculars')->get()->toArray());

        // Drop new tables
        Schema::dropIfExists('new_facilities');
        Schema::dropIfExists('new_academics');
        Schema::dropIfExists('new_extracurriculars');
    }
}
