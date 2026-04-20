<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model {
    protected $fillable = ['name', 'slug', 'icon', 'color', 'is_active'];
    public function questions() { return $this->hasMany(Question::class); }
    public function attempts() { return $this->hasMany(QuizAttempt::class); }
}
