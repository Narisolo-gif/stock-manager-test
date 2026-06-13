<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    // Modele client
    use HasFactory;
      protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
    ];

}
