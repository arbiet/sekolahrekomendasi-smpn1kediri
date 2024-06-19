<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitiesTable extends Migration
{
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_school_id')->constrained('schools')->onDelete('cascade');
            $table->string('facility_name');
            $table->text('facility_description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facilities');
    }
}
