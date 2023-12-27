<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobEstado extends Model
{
    use HasFactory;

    protected $table = 'job_estado';
    protected $fillable = ['executado', 'jobname'];
}
