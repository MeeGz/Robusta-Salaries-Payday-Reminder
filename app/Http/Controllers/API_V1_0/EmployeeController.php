<?php

namespace App\Http\Controllers\API_V1_0;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Employee::with('user')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'name' => 'required|max:255|min:2',
            'email'=> 'required|email|max:255|unique:users,email',
            'salary' => 'required|numeric',
            'bonus_rate' => 'required|numeric',
        ]);
        if ($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        if(User::addEmployee($request))
            return response()->json(null, 200);
        else
            return response()->json(null, 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $employee = Employee::where('user_id', $user_id)->with('user')->first();
        if(!$employee)
            return response()->json($employee, 404);
        return response()->json($employee, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $employee = Employee::where('user_id', $user_id)->with('user')->first();
        if(!$employee)
            return response()->json(null, 404);
        $validator =  Validator::make($request->all(), [
            'name' => 'sometimes|required|max:255|min:2',
            'email'=> 'sometimes|required|email|max:255|unique:users,email,' . $user_id,
            'salary' => 'sometimes|required|numeric',
            'bonus_rate' => 'sometimes|required|numeric',
        ]);
        if ($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()], 400);
        } 
        if($employee->updateEmployee($request))
            return response()->json(null, 200);
        return response()->json(null, 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $employee = Employee::where('user_id', $user_id)->with('user')->first();
        if(!$employee)
            return response()->json(null, 404);
        if($employee->destroyEmployee())
            return response()->json(null, 200);
        return response()->json(null, 400);
    }
}
