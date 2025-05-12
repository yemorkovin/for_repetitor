<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'about',
        'experience_years',
        'hourly_rate',
        'education_level',
        'video_presentation',
        'is_approved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'tutor_subject');
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->hourly_rate, 0, '.', ' ').' ₽/час';
    }
}