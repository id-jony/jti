<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentsResource;
use App\Http\Resources\EmployeesResource;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        return DepartmentsResource::collection(Department::all());
    }

    public function employees(Department $department)
    {
        return EmployeesResource::collection($department->employees);
    }
}
