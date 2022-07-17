<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::with('job', 'employeeDetail', 'payroll', 'job.department')->get();
        //dd($employees);
        $data = [];
        foreach($employees as $employee){
            $payrolls = $employee->payroll;
            $payrollData = [];
            //dd($employee->employeeDetail->address);

            foreach($payrolls as $payroll){
                array_push($payrollData, [
                    'performanceBonus' => $payroll->performance_bonus,
                    'bonus' => $payroll->bonus,
                    'transportationCost' => $payroll->transportation_cost,
                    'medicalCost' => $payroll->medical_cost,
                    'grossPay' => $payroll->gross_pay,
                    'date' => $payroll->date,
                ]);
            }

            array_push($data, [
                'id' => $employee->id,
                'name' => $employee->name,
                'email' => $employee->email,
                'phoneNo' => $employee->phone_no,
                'job' => $employee->job->name,
                'department' => $employee->job->department->name,
                'address' => $employee->employeeDetail==null ? "" : $employee->employeeDetail->address,
                'gender' => $employee->employeeDetail==null ? "" : $employee->employeeDetail->gender,
                'martialStatus' => $employee->employeeDetail==null ? "" : $employee->employeeDetail->martial_status,
                'religion' => $employee->employeeDetail==null ? "" : $employee->employeeDetail->religion,
                'image' => $employee->employeeDetail==null ? "" : $employee->employeeDetail->image_path,
                'payrolls' => $payrollData,
            ]);
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email|required',
            'phone_no' => 'required|numeric|digits:11',
            'job_id' => 'required|exists:jobs,id',
            'salary' => 'required',
            //'dept_id' => 'required|exists:departments,id',
        ]);

        $name = $request->name;
        $email = $request->email;
        $phoneNo = $request->phone_no;
        $jobId = $request->job_id;
        $salary = $request->salary;

        Employee::create([
            'name' => $name,
            'email' => $email,
            'phone_no' => $phoneNo,
            'job_id' => $jobId,
            'salary' => $salary,
        ]);

        return response()->json([
            'message' => 'Data inserted Successfully!'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
