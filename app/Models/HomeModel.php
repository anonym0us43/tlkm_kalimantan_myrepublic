<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HomeModel extends Model
{
    public static function dailyReport(string $startDate, string $endDate, ?string $area, ?string $woType): array
    {
        $query = DB::table('tb_stella_workorders as tsw')
            ->leftJoin('tb_webcc_wo_korlap as twk', 'tsw.workOrderNumber_id', '=', 'twk.wo_number_id')
            ->select([
                'tsw.area',
                DB::raw("SUM(CASE WHEN twk.installer IS NULL AND twk.slot_time = '09:00 - 11:00' THEN 1 ELSE 0 END) AS unassign_09to11"),
                DB::raw("SUM(CASE WHEN twk.installer IS NULL AND twk.slot_time = '11:01 - 13:00' THEN 1 ELSE 0 END) AS unassign_11to13"),
                DB::raw("SUM(CASE WHEN twk.installer IS NULL AND twk.slot_time = '13:01 - 15:00' THEN 1 ELSE 0 END) AS unassign_13to15"),
                DB::raw("SUM(CASE WHEN twk.installer IS NULL AND twk.slot_time = '15:00 - 17:00' THEN 1 ELSE 0 END) AS unassign_15to17"),
                DB::raw("SUM(CASE WHEN twk.installer IS NULL AND twk.slot_time = '17:01 - 19:00' THEN 1 ELSE 0 END) AS unassign_17to19"),
                DB::raw("SUM(CASE WHEN twk.installer IS NULL AND twk.slot_time = '19:01 - 21:00' THEN 1 ELSE 0 END) AS unassign_19to21"),
                DB::raw("SUM(CASE WHEN twk.installer IS NULL AND twk.slot_time = '21:01 - 23:00' THEN 1 ELSE 0 END) AS unassign_21to23"),
                DB::raw("SUM(CASE WHEN twk.installer IS NOT NULL AND twk.slot_time = '09:00 - 11:00' THEN 1 ELSE 0 END) AS onprogress_09to11"),
                DB::raw("SUM(CASE WHEN twk.installer IS NOT NULL AND twk.slot_time = '11:01 - 13:00' THEN 1 ELSE 0 END) AS onprogress_11to13"),
                DB::raw("SUM(CASE WHEN twk.installer IS NOT NULL AND twk.slot_time = '13:01 - 15:00' THEN 1 ELSE 0 END) AS onprogress_13to15"),
                DB::raw("SUM(CASE WHEN twk.installer IS NOT NULL AND twk.slot_time = '15:00 - 17:00' THEN 1 ELSE 0 END) AS onprogress_15to17"),
                DB::raw("SUM(CASE WHEN twk.installer IS NOT NULL AND twk.slot_time = '17:01 - 19:00' THEN 1 ELSE 0 END) AS onprogress_17to19"),
                DB::raw("SUM(CASE WHEN twk.installer IS NOT NULL AND twk.slot_time = '19:01 - 21:00' THEN 1 ELSE 0 END) AS onprogress_19to21"),
                DB::raw("SUM(CASE WHEN twk.installer IS NOT NULL AND twk.slot_time = '21:01 - 23:00' THEN 1 ELSE 0 END) AS onprogress_21to23"),
                DB::raw("SUM(CASE WHEN twk.wo_agent IS NULL AND twk.wo_installer IS NOT NULL THEN 1 ELSE 0 END) AS verification_agent"),
                DB::raw("SUM(CASE WHEN twk.wo_agent IS NOT NULL AND twk.wo_installer = 'Pending' THEN 1 ELSE 0 END) AS wo_pending"),
                DB::raw("SUM(CASE WHEN twk.wo_agent IS NOT NULL AND twk.wo_installer = 'Cancel' THEN 1 ELSE 0 END) AS wo_cancel"),
                DB::raw("SUM(CASE WHEN twk.wo_agent IS NOT NULL AND twk.wo_installer = 'Complete' THEN 1 ELSE 0 END) AS wo_complete"),
            ])
            ->whereBetween('twk.date_wo', [$startDate, $endDate]);

        if ($area)
        {
            $query->where('tsw.area', $area);
        }

        if ($woType)
        {
            $query->where('tsw.workOrderType', $woType);
        }

        return $query->groupBy('tsw.area')
            ->orderBy('tsw.area')
            ->get()
            ->map(function ($row)
            {
                $unassignTotal   = (int) $row->unassign_09to11 + (int) $row->unassign_11to13
                    + (int) $row->unassign_13to15 + (int) $row->unassign_15to17
                    + (int) $row->unassign_17to19 + (int) $row->unassign_19to21
                    + (int) $row->unassign_21to23;

                $onprogressTotal = (int) $row->onprogress_09to11 + (int) $row->onprogress_11to13
                    + (int) $row->onprogress_13to15 + (int) $row->onprogress_15to17
                    + (int) $row->onprogress_17to19 + (int) $row->onprogress_19to21
                    + (int) $row->onprogress_21to23;

                return [
                    'area'               => e($row->area),
                    'unassign_09to11'    => (int) $row->unassign_09to11,
                    'unassign_11to13'    => (int) $row->unassign_11to13,
                    'unassign_13to15'    => (int) $row->unassign_13to15,
                    'unassign_15to17'    => (int) $row->unassign_15to17,
                    'unassign_17to19'    => (int) $row->unassign_17to19,
                    'unassign_19to21'    => (int) $row->unassign_19to21,
                    'unassign_21to23'    => (int) $row->unassign_21to23,
                    'unassign_total'     => $unassignTotal,
                    'onprogress_09to11'  => (int) $row->onprogress_09to11,
                    'onprogress_11to13'  => (int) $row->onprogress_11to13,
                    'onprogress_13to15'  => (int) $row->onprogress_13to15,
                    'onprogress_15to17'  => (int) $row->onprogress_15to17,
                    'onprogress_17to19'  => (int) $row->onprogress_17to19,
                    'onprogress_19to21'  => (int) $row->onprogress_19to21,
                    'onprogress_21to23'  => (int) $row->onprogress_21to23,
                    'onprogress_total'   => $onprogressTotal,
                    'verification_agent' => (int) $row->verification_agent,
                    'wo_pending'         => (int) $row->wo_pending,
                    'wo_cancel'          => (int) $row->wo_cancel,
                    'wo_complete'        => (int) $row->wo_complete,
                ];
            })
            ->toArray();
    }

    public static function dailyReportDetail(
        string $startDate,
        string $endDate,
        ?string $area,
        ?string $woType,
        string $column
    ): array
    {
        $slotMap = [
            'unassign_09to11'   => '09:00 - 11:00',
            'unassign_11to13'   => '11:01 - 13:00',
            'unassign_13to15'   => '13:01 - 15:00',
            'unassign_15to17'   => '15:00 - 17:00',
            'unassign_17to19'   => '17:01 - 19:00',
            'unassign_19to21'   => '19:01 - 21:00',
            'unassign_21to23'   => '21:01 - 23:00',
            'onprogress_09to11' => '09:00 - 11:00',
            'onprogress_11to13' => '11:01 - 13:00',
            'onprogress_13to15' => '13:01 - 15:00',
            'onprogress_15to17' => '15:00 - 17:00',
            'onprogress_17to19' => '17:01 - 19:00',
            'onprogress_19to21' => '19:01 - 21:00',
            'onprogress_21to23' => '21:01 - 23:00',
        ];

        $query = DB::table('tb_stella_workorders as tsw')
            ->join('tb_webcc_wo_korlap as twk', 'tsw.workOrderNumber_id', '=', 'twk.wo_number_id')
            ->select([
                'tsw.workOrderType',
                'tsw.plan',
                'twk.id_customer',
                'twk.wo_number',
                'twk.date_wo',
                'twk.slot_time',
                'twk.installer',
                'twk.wo_agent',
                'twk.wo_reason_agent',
                'twk.wo_installer',
                'twk.wo_reason_installer',
                'twk.wo_remarks_installer',
                'twk.updated_at',
            ])
            ->whereBetween('twk.date_wo', [$startDate, $endDate]);

        if ($area)
        {
            $query->where('tsw.area', $area);
        }

        if ($woType)
        {
            $query->where('tsw.workOrderType', $woType);
        }

        if (str_starts_with($column, 'unassign_'))
        {
            $query->whereNull('twk.installer');
            if (isset($slotMap[$column]))
            {
                $query->where('twk.slot_time', $slotMap[$column]);
            }
        }
        elseif (str_starts_with($column, 'onprogress_'))
        {
            $query->whereNotNull('twk.installer');
            if (isset($slotMap[$column]))
            {
                $query->where('twk.slot_time', $slotMap[$column]);
            }
        }
        elseif ($column === 'verification_agent')
        {
            $query->whereNull('twk.wo_agent')->whereNotNull('twk.wo_installer');
        }
        elseif ($column === 'wo_pending')
        {
            $query->whereNotNull('twk.wo_agent')->where('twk.wo_installer', 'Pending');
        }
        elseif ($column === 'wo_cancel')
        {
            $query->whereNotNull('twk.wo_agent')->where('twk.wo_installer', 'Cancel');
        }
        elseif ($column === 'wo_complete')
        {
            $query->whereNotNull('twk.wo_agent')->where('twk.wo_installer', 'Complete');
        }

        return $query
            ->orderBy('twk.date_wo')
            ->orderBy('tsw.area')
            ->get()
            ->map(fn($row) => [
                'wo_type'            => $row->workOrderType ?? '-',
                'plan'               => $row->plan ?? '-',
                'id_customer'        => $row->id_customer ?? '-',
                'wo_number'          => $row->wo_number ?? '-',
                'date_wo'            => $row->date_wo ?? '-',
                'slot_time'          => $row->slot_time ?? '-',
                'installer'          => $row->installer ?? '-',
                'wo_agent'           => $row->wo_agent ?? '-',
                'wo_reason_agent'    => $row->wo_reason_agent ?? '-',
                'wo_installer'       => $row->wo_installer ?? '-',
                'wo_reason_installer' => $row->wo_reason_installer ?? '-',
                'wo_remarks'         => $row->wo_remarks_installer ?? '-',
                'updated_at'         => $row->updated_at ?? '-',
            ])
            ->toArray();
    }

    public static function distinctAreas(): array
    {
        try
        {
            return DB::table('tb_stella_workorders')
                ->distinct()
                ->orderBy('area')
                ->pluck('area')
                ->filter()
                ->values()
                ->toArray();
        }
        catch (\Exception $e)
        {
            return [];
        }
    }

    public static function distinctWoTypes(): array
    {
        try
        {
            return DB::table('tb_stella_workorders')
                ->distinct()
                ->orderBy('workOrderType')
                ->pluck('workOrderType')
                ->filter()
                ->values()
                ->toArray();
        }
        catch (\Exception $e)
        {
            return [];
        }
    }
}
