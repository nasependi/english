<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'submission';

    protected $guarded = [
        'id'
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
