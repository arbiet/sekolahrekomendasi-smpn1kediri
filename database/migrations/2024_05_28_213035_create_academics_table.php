<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicsTable extends Migration
{
    public function up()
    {
        Schema::create('academics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_school_id')->constrained('schools')->onDelete('cascade');
            $table->decimal('passing_rate', 5, 2);
            $table->decimal('average_score', 5, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('academics');
    }
}
