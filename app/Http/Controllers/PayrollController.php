<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validate = validator($request->only(
            'emp_id',
            'performance_bonus',
            'bonus',
            'transportation_cost',
            'medical_cost',
        ), [
            'emp_id' => 'required|exists:employees,id',
            'performance_bonus' => 'required',
            'bonus' => 'required',
            'transportation_cost' => 'required',
            'medical_cost' => 'required'
        ]);

        if($validate->fails()){
            return response()->json($validate->errors()->all(), 400);
        }

        $empId = $request->emp_id;
        $performanceBonus = $request->performance_bonus;
        $bonus = $request->bonus;
        $tranportationCost = $request->transportation_cost;
        $medicalCost = $request->medical_cost;
        $salary = Employee::select('salary')->where('id', $empId)->first();
        $salary = $salary->salary;
        $grossPay = $salary + ($performanceBonus*$salary)/3 + $bonus + $tranportationCost + $medicalCost;
        
        $payrollCreate= Payroll::create([
            'emp_id' => $empId,
            'performance_bonus' => $performanceBonus,
            'bonus' => $bonus,
            'transportation_cost' => $tranportationCost,
            'medical_cost' => $medicalCost,
            'gross_pay' => $grossPay,
        ]);
        if($payrollCreate){
           Employee::find($empId)->touch();
        }

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
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function show(Payroll $payroll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function edit(Payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payroll $payroll)
    {
        //
    }
}
