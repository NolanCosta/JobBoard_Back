<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowAdvertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_sent',
        'lastname',
        'firstname',
        'email',
        'phone',
        'message',
        'status',
        'user_id',
        'advertisement_id',
    ];
}
