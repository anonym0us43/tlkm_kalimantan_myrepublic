<?php

namespace App\Http\Controllers;

use App\Models\HomeModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function dailyReportView()
    {
        $areas   = HomeModel::distinctAreas();
        $woTypes = HomeModel::distinctWoTypes();

        return view('dashboard.daily-report', compact('areas', 'woTypes'));
    }

    public function dailyReport(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date'   => ['required', 'date'],
            'end_date'     => ['required', 'date', 'after_or_equal:start_date'],
            'area'         => ['nullable', 'string', 'max:100'],
            'wo_type'      => ['nullable', 'array'],
            'wo_type.*'    => ['string', 'max:100'],
        ]);

        $data = HomeModel::dailyReport(
            $validated['start_date'],
            $validated['end_date'],
            $validated['area'] ?? null,
            $validated['wo_type'] ?? null
        );

        return response()->json(['data' => $data]);
    }

    public function kpiSummary(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            'area'       => ['nullable', 'string', 'max:100'],
            'wo_type'    => ['nullable', 'array'],
            'wo_type.*'  => ['string', 'max:100'],
        ]);

        $data = HomeModel::kpiSummary(
            $validated['start_date'],
            $validated['end_date'],
            $validated['area'] ?? null,
            $validated['wo_type'] ?? null
        );

        return response()->json(['data' => $data]);
    }

    public function dailyReportDetail(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date'   => ['required', 'date'],
            'end_date'     => ['required', 'date', 'after_or_equal:start_date'],
            'area'         => ['nullable', 'string', 'max:100'],
            'wo_type'      => ['nullable', 'array'],
            'wo_type.*'    => ['string', 'max:100'],
            'column'       => ['required', 'string', Rule::in(HomeModel::reportColumns())],
        ]);

        $data = HomeModel::dailyReportDetail(
            $validated['start_date'],
            $validated['end_date'],
            $validated['area'] ?? null,
            $validated['wo_type'] ?? null,
            $validated['column']
        );

        return response()->json(['data' => $data]);
    }
}
