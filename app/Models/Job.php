<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dept_id',
    ];

    public function employee(){
        return $this->hasMany(Employee::class, 'job_id', 'id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'dept_id', 'id');
    }
}
