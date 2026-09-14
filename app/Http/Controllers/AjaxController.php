<?php

namespace App\Http\Controllers;

use App\Models\AreaModel;
use App\Models\EmployeeModel;
use App\Models\RoleModel;
use Illuminate\Http\JsonResponse;

class AjaxController extends Controller
{
    public function areaData(): JsonResponse
    {
        return response()->json(['data' => AreaModel::tableData()]);
    }

    public function roleData(): JsonResponse
    {
        return response()->json(['data' => RoleModel::tableData()]);
    }

    public function employeeData(): JsonResponse
    {
        return response()->json(['data' => EmployeeModel::tableData()]);
    }
}
