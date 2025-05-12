<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('tutor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('about')->nullable();
            $table->integer('experience_years')->default(0);
            $table->decimal('hourly_rate', 8, 2)->default(0);
            $table->string('education_level')->nullable();
            $table->string('video_presentation')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tutor_profiles');
    }
}