<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'price', 'level', 'instructor_id'];
 
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
 
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order', 'asc');
    }
 
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }
 
    public function reviews()
    {
        return $this->hasMany(Review::class,'user_id');
    }
}
