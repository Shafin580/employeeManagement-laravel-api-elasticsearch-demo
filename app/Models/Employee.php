<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ElasticScoutDriverPlus\Searchable;
use ElasticAdapter\Exceptions\BulkRequestException;

class Employee extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'job_id',
        'deleted_at',
        'salary',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function employeeDetail()
    {
        return $this->hasOne(EmployeeDetail::class, 'emp_id', 'id');
    }

    public function payroll()
    {
        return $this->hasMany(Payroll::class, 'emp_id', 'id');
    }

    public function searchableAs()
    {
        return 'employee_index';
    }

    public function toSearchableArray()
    {
        $employees = $this::with(['job', 'employeeDetail', 'payroll', 'job.department' => function ($q) {
            $q->latest();
        }])->where('id', $this->id)->get();
        
        foreach ($employees as $employee) {
            $payrolls = $employee->payroll;
            $payrollData = [];

                foreach ($payrolls as $payroll) {
                    array_push($payrollData, [
                        'performanceBonus' => $payroll->performance_bonus,
                        'bonus' => $payroll->bonus,
                        'transportationCost' => $payroll->transportation_cost,
                        'medicalCost' => $payroll->medical_cost,
                        'grossPay' => $payroll->gross_pay,
                        'date' => $payroll->date,
                    ]);
                }
                $results = [
                    "employeeId" => $employee->id,
                    "employeeName" => $employee->name,
                    'employeeEmail' => $employee->email,
                    'employeePhoneNo' => $employee->phone_no,
                    'employeeJob' => $employee->job->name,
                    'employeeSalary' => $employee->salary,
                    'employeeDepartment' => $employee->job->department->name,
                    'employeeAddress' => $employee->employeeDetail ?  $employee->employeeDetail->address : "" ,
                    'employeeGender' => $employee->employeeDetail ?  $employee->employeeDetail->gender : "" ,
                    'employeeMartialStatus' => $employee->employeeDetail ?  $employee->employeeDetail->martial_status : "" ,
                    'employeeReligion' => $employee->employeeDetail ?  $employee->employeeDetail->religion : "" ,
                    'employeeImage' => $employee->employeeDetail ?  $employee->employeeDetail->image_path : "" ,
                    'employeePayrolls' => $payrollData,
                    "created_at" => $employee->created_at,
                    "updated_at" => $employee->updated_at
                ];

                //dd($payrollData);
        }
        //dd($results);
        return $results;
    }
}
