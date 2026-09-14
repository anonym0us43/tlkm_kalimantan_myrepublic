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
        $allowedColumns = [
            'unassign_09to11',
            'unassign_11to13',
            'unassign_13to15',
            'unassign_15to17',
            'unassign_17to19',
            'unassign_19to21',
            'unassign_21to23',
            'unassign_total',
            'onprogress_09to11',
            'onprogress_11to13',
            'onprogress_13to15',
            'onprogress_15to17',
            'onprogress_17to19',
            'onprogress_19to21',
            'onprogress_21to23',
            'onprogress_total',
            'verification_agent',
            'wo_pending',
            'wo_cancel',
            'wo_complete',
            'total_wo',
        ];

        $validated = $request->validate([
            'start_date'   => ['required', 'date'],
            'end_date'     => ['required', 'date', 'after_or_equal:start_date'],
            'area'         => ['nullable', 'string', 'max:100'],
            'wo_type'      => ['nullable', 'array'],
            'wo_type.*'    => ['string', 'max:100'],
            'column'       => ['required', 'string', Rule::in($allowedColumns)],
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
