<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $table = 'educations';

    protected $fillable = [
        'tutor_profile_id',
        'institution',
        'degree',
        'specialization',
        'year_graduated',
    ];

    public function tutorProfile()
    {
        return $this->belongsTo(TutorProfile::class);
    }
}