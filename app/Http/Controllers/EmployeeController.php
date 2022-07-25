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
        // $employees = Employee::with('job', 'employeeDetail', 'payroll', 'job.department')->get();
        // //dd($employees);
        // $data = [];
        // foreach($employees as $employee){
        //     $payrolls = $employee->payroll;
        //     $payrollData = [];
        //     //dd($employee->employeeDetail->address);

        //     foreach($payrolls as $payroll){
        //         array_push($payrollData, [
        //             'performanceBonus' => $payroll->performance_bonus,
        //             'bonus' => $payroll->bonus,
        //             'transportationCost' => $payroll->transportation_cost,
        //             'medicalCost' => $payroll->medical_cost,
        //             'grossPay' => $payroll->gross_pay,
        //             'date' => $payroll->date,
        //         ]);
        //     }

        //     array_push($data, [
        //         'id' => $employee->id,
        //         'name' => $employee->name,
        //         'email' => $employee->email,
        //         'phoneNo' => $employee->phone_no,
        //         'job' => $employee->job->name,
        //         'department' => $employee->job->department->name,
        //         'address' => $employee->employeeDetail==null ? "" : $employee->employeeDetail->address,
        //         'gender' => $employee->employeeDetail==null ? "" : $employee->employeeDetail->gender,
        //         'martialStatus' => $employee->employeeDetail==null ? "" : $employee->employeeDetail->martial_status,
        //         'religion' => $employee->employeeDetail==null ? "" : $employee->employeeDetail->religion,
        //         'image' => $employee->employeeDetail==null ? "" : $employee->employeeDetail->image_path,
        //         'payrolls' => $payrollData,
        //     ]);
        // }

        // return response()->json([
        //     'data' => $data,
        // ]);

        $searchQuery = [
            'bool' => [
                'must' => [
                    'match_all' => (object)[],
                ],
            ],
        ];
        $getSearchResults = Employee::searchQuery($searchQuery)
            ->size(100)->raw();
        $results = $getSearchResults['hits']['hits'];
        $data = [];
        foreach ($results as $result) {
            $payrollData = [];
            foreach ($result['_source']['employeePayrolls'] as $payResult) {
                array_push($payrollData, [
                    'performanceBonus' => $payResult['performanceBonus'],
                    'bonus' => $payResult['bonus'],
                    'transportationCost' => $payResult['transportationCost'],
                    'medicalCost' => $payResult['medicalCost'],
                    'grossPay' => $payResult['grossPay'],
                    'date' => $payResult['date'],
                ]);
            }

            array_push($data, [
                'id' => $result['_source']['employeeId'],
                'name' => $result['_source']['employeeName'],
                'email' => $result['_source']['employeeEmail'],
                'phoneNo' => $result['_source']['employeePhoneNo'],
                'job' => $result['_source']['employeeJob'],
                'salary' => $result['_source']['employeeSalary'],
                'department' => $result['_source']['employeeDepartment'],
                'address' => $result['_source']['employeeAddress'],
                'gender' => $result['_source']['employeeGender'],
                'martialStatus' => $result['_source']['employeeMartialStatus'],
                'religion' => $result['_source']['employeeReligion'],
                'image' => $result['_source']['employeeImage'],
                'payrolls' => $payrollData,
            ]);
        }
        return response()->json([
            'status_code' => 200,
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

        $employeeCreate = Employee::create([
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

    public function test(Request $request)
    {

        $department = "";
        $name = "";
        $job = "";
        $gender = "";
        $martialStatus = "";
        $religion = "";
        $performanceBonus = 0;
        $bonus = 0;
        $transportationCost = 0;
        $date = "";
        $prefixValue = "";
        $genderQuery = [];
        $martialStatusQuery = [];
        $religionQuery = [];
        $performanceBonusQuery = [];
        $bonusQuery = [];
        $transportationCostQuery = [];
        $dateQuery = [];
        $departmentQuery = [];
        $nameQuery = [];
        $jobQuery = [];

        //dd(count($request->request));

        if (isset($request->department)) {
            $department = $request->department;
            $departmentQuery = [
                'match' => [
                    'employeeDepartment' => $department,
                ],
            ];
        }

        if (isset($request->name)) {
            $name = $request->name;
            $nameQuery = [
                "match" => [
                    'employeeName' => $name,
                ],
            ];
        }

        if (isset($request->job)) {
            $job = $request->job;
            $jobQuery = ["match" => [
                'employeeJob' => $job,
            ],];
        }

        if (isset($request->gender)) {
            $gender = $request->gender;
            $genderQuery = ["match" => [
                'employeeGender' => $gender,
            ],];
        }

        if (isset($request->martialStatus)) {
            $martialStatus = $request->martialStatus;
            $martialStatusQuery = ["match" => [
                'employeeMartialStatus' => $martialStatus,
            ],];
        }

        if (isset($request->religion)) {
            $religion = $request->religion;
            $religionQuery = ["match" => [
                'employeeReligion' => $religion,
            ],];
        }

        if (isset($request->performanceBonus)) {
            $performanceBonus = $request->performanceBonus;
            $performanceBonusQuery = ["range" => [
                'employeePayRolls.performanceBonus' => [
                    'lte' => $performanceBonus,
                ],
            ],];
        }

        if (isset($request->bonus)) {
            $bonus = $request->bonus;
            $bonusQuery = [
                "range" => [
                    "employeePayrolls.bonus" => [
                        'gte' => $bonus,
                    ],
                ],
            ];
        }

        if(isset($request->prefixValue)){
            $prefixValue = $request->prefixValue;
        }

        //dd($department);

        $searchQuery = [
            'bool' => [
                'must' => $departmentQuery,
                "filter" => [
                    "bool" => [
                        "must" => $nameQuery,
                        "filter" => [
                            "bool" => [
                                "must" => $jobQuery,
                                "filter" => [
                                    "bool" => [
                                        "must" => $genderQuery,
                                        "filter" => [
                                            "bool" => [
                                                "must" => $martialStatusQuery,
                                                "filter" => [
                                                    "bool" => [
                                                        "must" => $religionQuery,
                                                        "filter" => [
                                                            "bool" => [
                                                                "must" => $bonusQuery
                                                            ],
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],

                /////
                // 'must' => [
                //     "match" => [
                //         'employeeName' => 'shafin',
                //     ],
                // ],
                // "filter" => [
                //     "bool" => [
                //         "must" => [
                //             "range" => [
                //                 "employeeSalary" => [
                //                     'gte' => 50000,
                //                     'lte' => 90000
                //                 ]
                //             ]
                //         ],
                //     ],
                // ],
                //////
                // "filter" => [
                //     "bool" => [
                //         "must" => [
                //             "range" => [
                //                 "employeeSalary" => [
                //                     'gte' => 20000,
                //                     'lte' => 90000
                //                 ]
                //             ]
                //         ]
                //     ]
                // ],
                // "filter" => [
                //     "bool" => [
                //         "must" => [
                //             "match" => [
                //                 "employeeDepartment" =>"HRM"
                //             ]
                //         ]
                //     ]
                // ]
                //////
                // "filter" => [
                //     "bool" => [
                //         "must" => [
                //             "range" => [
                //                 "employeePayrolls.bonus" => [
                //                     'gte' => 7000,
                //                 ],
                //             ],
                //         ],
                //     ],
                // ],
            ]
        ];
        //$getSearchResults = Employee::SearchQuery($searchQuery)->size(100)->raw();

        //////
        // $multiMatchValue = "";

        // if($request->multiMatchValue){
        //     $multiMatchValue = $request->multiMatchValue;
        // }

        // $multiMatchQuery = [
        //     "bool" => [
        //     "must" => [
        //         "multi_match" => [
        //             "query" => $multiMatchValue,
        //             "fields" => ["employeeName", "employeeEmail", "employeePhoneNo", "employeeJob", "employeeAddress"],
        //         ],
        //     ],
        // ],];

        // $multiMatchResult = Employee::searchQuery($multiMatchQuery)->size(100)->raw();
        // dd($multiMatchResult['hits']['hits']);

        //dd($getSearchResults['hits']['hits']);

        //////

        // $prefixQuery = [
        //     'bool' => [
        //         'must' => [
        //             'prefix' => [
        //                 'employeeDepartment' => [
        //                     'value' => $prefixValue,
        //                 ],
        //             ],
        //         ],
        //     ],
        // ];

        // $prefixResult = Employee::searchQuery($prefixQuery)->size(100)->raw();
        // dd($prefixResult['hits']['hits']);

        // $filteredQuery = [
        //     'bool' => [
        //         'must' => [
        //             'filtered' => [
        //                 'bool' => [
        //                     'must' => [
        //                         'query' => [
        //                             'term' => [
        //                                 'employeeDepartment' => 'software',
        //                             ],
        //                         ],
        //                         'filter' => [
        //                             'bool' => [
        //                                 'must' => [
        //                                     'range' => [
        //                                         'employeeSalary' => [
        //                                             'gte' => 60000,
        //                                         ],
        //                                     ],
        //                                 ],
        //                             ],
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //         ],
        //     ],
        // ];

        // $filteredResult = Employee::searchQuery($filteredQuery)->size(100)->raw();
        // dd($filteredResult['hits']['hits']);

        //////

        // $aggsQuery = [
            
                    
        //                 'max_salary' => [
        //                     'max' => [
        //                         'field' => 'employeeSalary',
        //                     ],
        //                 ],
                    
                
        // ];

        // $aggsResult = Employee::searchQuery($searchQuery)->aggregateRaw($aggsQuery)->size(100)->raw();
        // dd($aggsResult['aggregations']);

        ///////

        // $fuzzyQuery = [
        //     'bool' => [
        //         'must' => [
        //             'fuzzy' => [
        //                 'employeeDepartment' => [
        //                     'value' => 'marteking',
        //                     'fuzziness' => 'AUTO',
        //                     "max_expansions" => 50,
        //                     "prefix_length" => 0,
        //                     "transpositions" => true,
        //                     "rewrite" => "constant_score",
        //                 ],
        //             ],
        //         ],
        //     ],
        // ];

        // $fuzzyResult = Employee::searchQuery($fuzzyQuery)->size(100)->raw();
        // dd($fuzzyResult['hits']['hits']);
        
        //////

    }
}
