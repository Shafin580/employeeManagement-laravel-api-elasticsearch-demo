<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EmployeeDetailController extends Controller
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
        $validate=validator($request->only(
            'emp_id',
            'image_path'
        ), [
            'emp_id' => 'required|exists:employees,id',
            'image_path' => 'mimes:jpg,jpeg,png|max:2048',
        ]);
        if($validate->fails()){
            return response()->json($validate->errors()->all(), 400);
        }

        $empId = $request->emp_id;
        $address = $request->address;
        $gender = $request->gender;
        $martialStatus = $request->martial_status;
        $religion = $request->religion;
        $image = $request->image_path;

        if($image){
            $time = Carbon::now()->timestamp;
            $filename = strval($time)."-".$image->getClientOriginalName();
            $image->move(public_path('storage/images/employeeProfileImages/'), $filename);
            $image = $filename;
        }

        $employeeDetailCreate = EmployeeDetail::create([
            'emp_id' => $empId,
            'address' => $address,
            'gender' => $gender,
            'martial_status' => $martialStatus,
            'religion' => $religion,
            'image_path' => $image,
        ]);

        if($employeeDetailCreate){
            Employee::find($empId)->touch();
         }
 
         return response()->json([
             'message' => 'Data inserted Successfully!'
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
     * @param  \App\Models\EmployeeDetail  $employeeDetail
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeDetail $employeeDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeDetail  $employeeDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeDetail $employeeDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeDetail  $employeeDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeDetail $employeeDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeDetail  $employeeDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeDetail $employeeDetail)
    {
        //
    }
}
