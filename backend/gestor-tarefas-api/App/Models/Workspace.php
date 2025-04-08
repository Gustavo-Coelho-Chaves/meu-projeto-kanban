<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'type'];

    public function flows()
    {
        return $this->hasMany(Flow::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

