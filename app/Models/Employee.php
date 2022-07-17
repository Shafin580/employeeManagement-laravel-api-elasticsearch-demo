<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'job_id',
        'deleted_at',
        'salary',
    ];

    public function job(){
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function employeeDetail(){
        return $this->hasOne(EmployeeDetail::class, 'emp_id', 'id');
    }

    public function payroll(){
        return $this->hasMany(Payroll::class, 'emp_id', 'id');
    }
}
