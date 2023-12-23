<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function index(){
        $employees = Employee::with('department','achievement')->get();
        $employees = $employees->map(function ($employee) {
            return [
                'id'         => $employee->id,
                'name'       => $employee->name,
                'email'      => $employee->email,
                'phone'      => $employee->phone,
                'address'    => $employee->address,
                'department' => $employee->department->name,
                'achievement' =>implode(', ', $employee->achievement->pluck('name')->toArray()),
            ];
        }); 

        return Inertia::render('employee/index',['employees'=>$employees]);
    } 

    public function create(){
        $departments = Department::all();
        $Achievements = Achievement::all();
        return Inertia::render('employee/create',['departments'=>$departments,'achievements'=>$Achievements]);
    } 

    public function store(Request $request){
        $request->validate([
            'name'       => 'required|string',
            'email'      => 'required|email|unique:users',
            'phone'      => 'required',
            'address'    => 'required',
            'department' => 'required',
        ]);

        $employee = new Employee();
        $employee->name           = $request->name;  
        $employee->email          = $request->email;  
        $employee->phone          = $request->phone;  
        $employee->address        = $request->address;  
        $employee->department_id  = $request->department;  
        $employee->save();
        $employee->achievement()->attach($request->achievement);
        $employee->save(); 
        
        return redirect()->route('employees')->with('message', 'Employee Created Successfully');
    }

    public function edit($id){
        $departments = Department::all();
        $achievements = Achievement::all();
        $employee_data = Employee::with('department', 'achievement')->find($id);
        if($employee_data){
            $employee = [
                'id'          => $employee_data->id,
                'name'        => $employee_data->name,
                'email'       => $employee_data->email,
                'phone'       => $employee_data->phone,
                'address'     => $employee_data->address,
                'department'  => $employee_data->department->id,
                'achievement' => $employee_data->achievement->map(function ($achievement) {
                                    return [
                                        'achievement_id'   => $achievement->id,
                                        'achievement_date' => $achievement->pivot->achievement_date,
                                    ];
                                })
            ];
        }
  
        return Inertia::render('employee/edit',['employee'=>$employee,'departments'=>$departments,'achievements'=>$achievements]);
    }

    public function destroy($id){
        Employee::destroy($id);
        return redirect()->route('employees');
    }
}
