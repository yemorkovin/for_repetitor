<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorSubjectTable extends Migration
{
    public function up()
    {
        Schema::create('tutor_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_profile_id')->constrained('tutor_profiles')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['tutor_profile_id', 'subject_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tutor_subject');
    }
}