<?php

namespace App\Models;

use App\Traits\UsesUuId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, UsesUuId;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'role',
        'file'
    ];
}
