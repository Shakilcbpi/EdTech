<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $fillable = ['user_id', 'course_id', 'rating', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
}
