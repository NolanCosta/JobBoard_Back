<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'sector',
        'description',
        'wage',
        'working_time',
        'skills',
        'tags',
        'zip_code',
        'city',
        'status',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
