<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'material';

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function assignments()
    {
        return $this->hasMany(\App\Models\Assignment::class, 'material_id');
    }
}
