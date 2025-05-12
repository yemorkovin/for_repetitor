<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationsTable extends Migration
{
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tutor_profile_id');
            $table->string('institution');
            $table->string('degree');
            $table->string('specialization');
            $table->year('year_graduated');
            $table->timestamps();

            $table->foreign('tutor_profile_id')
                ->references('id')
                ->on('tutor_profiles')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('educations');
    }
}
