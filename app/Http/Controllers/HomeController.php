<?php

namespace App\Http\Controllers;

use App\Models\HomeModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $areas   = HomeModel::distinctAreas();
        $woTypes = HomeModel::distinctWoTypes();

        return view('home', compact('areas', 'woTypes'));
    }

    public function dailyReport(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            'area'       => ['nullable', 'string', 'max:100'],
            'wo_type'    => ['nullable', 'string', 'max:100'],
        ]);

        $data = HomeModel::dailyReport(
            $validated['start_date'],
            $validated['end_date'],
            $validated['area'] ?? null,
            $validated['wo_type'] ?? null
        );

        return response()->json(['data' => $data]);
    }
}
