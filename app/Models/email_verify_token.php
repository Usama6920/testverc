<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class email_verify_token extends Model
{
    use HasFactory;
    protected $fillable = [
      'email',
      'token'
  ];
}
