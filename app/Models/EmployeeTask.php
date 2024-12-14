<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class EmployeeTask extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeTaskFactory> */
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'taskId',
        'emplyeeId',
    ];
}
