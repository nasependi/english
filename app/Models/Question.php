<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'question';

    protected $casts = [
        'options' => 'array', // Assuming options are stored as JSON
        'answer_key' => 'array', // Assuming answer_key is also stored as JSON
    ];

    protected $guarded = [
        'id'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
