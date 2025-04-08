<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailVerification extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'code', 'expires_at'];

    protected $dates = ['expires_at'];
}
