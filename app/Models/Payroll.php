<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'performance_bonus',
        'bonus',
        'transportation_cost',
        'medical_cost',
        'gross_pay',
        'date'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
