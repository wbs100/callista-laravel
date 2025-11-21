<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'phone',
        'projectType',
        'budget',
        'timeline',
        'location',
        'projectDescription',
        'inspiration',
        'newsletter',
    ];
}
