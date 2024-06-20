<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usersubscription extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id',
      'plan_id',
      'start_date',
      'expiry_date'

  ];
}
