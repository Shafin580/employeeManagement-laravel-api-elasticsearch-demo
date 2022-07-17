<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'address',
        'gender',
        'martial_status',
        'religion',
        'image_path',
    ];

    public function employee(){
        $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
