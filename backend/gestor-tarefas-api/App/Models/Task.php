<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'flow_id', 'title', 'description', 'due_date', 'priority'
    ];

    public function flow()
    {
        return $this->belongsTo(Flow::class);
    }
}
