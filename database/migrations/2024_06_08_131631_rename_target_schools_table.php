<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('target_schools', 'schools');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('schools', 'target_schools');
    }
}
