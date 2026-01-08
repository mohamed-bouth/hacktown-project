<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'type',
        'category',
        'city',
        'location_text',
        'description',
        'whatsapp',
        'phone',
        'status',
    ];
}
