<?php

namespace App\Models;

use App\Traits\UsesUuId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory, HasApiTokens, UsesUuId;

    protected $fillable = [
        'uuid',
        'title',
        'description',
        'deadline',
        'status',
        'creator'
    ];
}
