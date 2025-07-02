<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'quiz';

    protected $guarded = [
        'id'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
