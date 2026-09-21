<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HomeModel extends Model
{
    private const SLOT_TIMES = [
        '09to11' => '09:00 - 11:00',
        '11to13' => '11:01 - 13:00',
        '13to15' => '13:01 - 15:00',
        '15to17' => '15:00 - 17:00',
        '17to19' => '17:01 - 19:00',
        '19to21' => '19:01 - 21:00',
        '21to23' => '21:01 - 23:00',
    ];

    private const REASON_AGENT        = "COALESCE(twk.wo_reason_agent, '')";
    private const IS_NOT_VISITED      = self::REASON_AGENT . " LIKE '%Tidak Dapat Berkunjung%'";
    private const IS_NETWORK_PROBLEM  = self::REASON_AGENT . " LIKE '%Masalah Jaringan%'";
    private const IS_INSTALLER_EMPTY  = "COALESCE(twk.installer, '') = ''";
    private const IS_INSTALLER_WORKING = "COALESCE(twk.installer, '') <> '' AND twk.wo_installer IS NULL";
    private const IS_PAST_CUTOFF      = "NOW() >= TIMESTAMP(twk.date_wo, '21:00:00')";
    private const HAS_ARRIVAL_AND_SLOT = "(NULLIF(tswd.arrival_time, '') IS NOT NULL AND tsw.slotTime REGEXP '^[0-9]{2}:')";
    private const IS_ARRIVAL_ON_TIME   = "(" . self::HAS_ARRIVAL_AND_SLOT
        . " AND TIME(tswd.arrival_time) <= MAKETIME(CAST(SUBSTRING(tsw.slotTime, 1, 2) AS UNSIGNED), 30, 0))";

    private const KPI_WO_TYPES = ['Maintenance'];

    private const STATUS_CONDITIONS = [
        'no_handle_team'     => '(' . self::IS_INSTALLER_EMPTY
            . ' OR (' . self::IS_INSTALLER_WORKING . ' AND ' . self::IS_PAST_CUTOFF . ')'
            . ' OR ' . self::IS_NOT_VISITED . ')',
        'onprogress_total'   => '(' . self::IS_INSTALLER_WORKING . ' AND NOT ' . self::IS_PAST_CUTOFF . ')',
        'verification_agent' => '(twk.wo_installer IS NOT NULL AND twk.wo_agent IS NULL)',
        'wo_pending'         => "(twk.wo_agent = 'Pending' AND NOT " . self::IS_NETWORK_PROBLEM . ')',
        'wo_cancel'          => "(twk.wo_agent = 'Cancel')",
        'wo_complete'        => "(twk.wo_agent = 'Complete' OR (twk.wo_agent = 'Pending' AND " . self::IS_NETWORK_PROBLEM . '))',
        'total_wo'           => '(1 = 1)',
    ];

    public static function reportColumns(): array
    {
        return array_keys(self::columnConditions());
    }

    private static function columnConditions(): array
    {
        $conditions = ['no_handle_team' => self::STATUS_CONDITIONS['no_handle_team']];

        foreach (self::SLOT_TIMES as $slotKey => $slotTime)
        {
            $conditions["onprogress_{$slotKey}"] = self::STATUS_CONDITIONS['onprogress_total']
                . " AND twk.slot_time = '{$slotTime}'";
        }

        return $conditions + self::STATUS_CONDITIONS;
    }

    private static function baseQuery(string $startDate, string $endDate, ?string $area, ?array $woTypes)
    {
        $query = DB::table('tb_webcc_wo_korlap as twk')
            ->join('tb_stella_workorders as tsw', 'tsw.workOrderNumber_id', '=', 'twk.wo_number_id')
            ->whereBetween('twk.date_wo', [$startDate, $endDate]);

        if ($area)
        {
            $query->where('tsw.area', $area);
        }

        if (!empty($woTypes))
        {
            $query->whereIn('tsw.workOrderType', $woTypes);
        }

        return $query;
    }

    private static function countWhen(string $condition, string $alias)
    {
        return DB::raw("SUM(CASE WHEN {$condition} THEN 1 ELSE 0 END) AS {$alias}");
    }

    public static function dailyReport(string $startDate, string $endDate, ?string $area, ?array $woTypes): array
    {
        $columnConditions = self::columnConditions();
        $selects          = ['tsw.area'];

        foreach ($columnConditions as $column => $condition)
        {
            $selects[] = self::countWhen($condition, $column);
        }

        return self::baseQuery($startDate, $endDate, $area, $woTypes)
            ->select($selects)
            ->groupBy('tsw.area')
            ->orderBy('tsw.area')
            ->get()
            ->map(function ($row) use ($columnConditions)
            {
                $reportRow = ['area' => e($row->area)];

                foreach (array_keys($columnConditions) as $column)
                {
                    $reportRow[$column] = (int) $row->{$column};
                }

                return $reportRow;
            })
            ->toArray();
    }

    public static function dailyReportDetail(
        string $startDate,
        string $endDate,
        ?string $area,
        ?array $woTypes,
        string $column
    ): array
    {
        return self::baseQuery($startDate, $endDate, $area, $woTypes)
            ->whereRaw(self::columnConditions()[$column])
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
            ->orderBy('twk.date_wo')
            ->orderBy('tsw.area')
            ->get()
            ->map(fn($row) => [
                'wo_type'             => $row->workOrderType ?? '-',
                'plan'                => $row->plan ?? '-',
                'id_customer'         => $row->id_customer ?? '-',
                'wo_number'           => $row->wo_number ?? '-',
                'date_wo'             => $row->date_wo ?? '-',
                'slot_time'           => $row->slot_time ?? '-',
                'installer'           => $row->installer ?? '-',
                'wo_agent'            => $row->wo_agent ?? '-',
                'wo_reason_agent'     => $row->wo_reason_agent ?? '-',
                'wo_installer'        => $row->wo_installer ?? '-',
                'wo_reason_installer' => $row->wo_reason_installer ?? '-',
                'wo_remarks'          => $row->wo_remarks_installer ?? '-',
                'updated_at'          => $row->updated_at ?? '-',
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

    private static function kpiMetricConditions(): array
    {
        $status = self::STATUS_CONDITIONS;

        $isClosed  = "({$status['wo_cancel']} OR {$status['wo_complete']})";
        $isVisited = "(({$status['verification_agent']} OR {$status['wo_pending']} OR {$isClosed})"
            . ' AND NOT ' . self::IS_NOT_VISITED . ')';
        $isCompleteWithin24h = "({$status['wo_complete']} AND twk.updated_at <= DATE_ADD(twk.date_wo, INTERVAL 1 DAY))";
        $isNotCancel         = "(COALESCE({$status['wo_cancel']}, 0) = 0)";

        return [
            'otr' => ['numerator' => self::IS_ARRIVAL_ON_TIME, 'denominator' => self::HAS_ARRIVAL_AND_SLOT],
            'vr'  => ['numerator' => $isVisited, 'denominator' => '(1 = 1)'],
            'sla' => ['numerator' => $isCompleteWithin24h, 'denominator' => $isNotCancel],
            'sr'  => ['numerator' => $status['wo_complete'], 'denominator' => $isNotCancel],
        ];
    }

    public static function kpiMetrics(): array
    {
        return array_keys(self::kpiMetricConditions());
    }

    private static function kpiCountSelects(): array
    {
        $conditions = self::kpiMetricConditions();

        return [
            DB::raw('COUNT(*) AS total_wo'),
            self::countWhen($conditions['otr']['denominator'], 'arrival_wo'),
            self::countWhen($conditions['otr']['numerator'], 'on_time_wo'),
            self::countWhen($conditions['vr']['numerator'], 'visited_wo'),
            self::countWhen($conditions['sr']['numerator'], 'complete_wo'),
            self::countWhen($conditions['sla']['numerator'], 'complete_24h_wo'),
            self::countWhen(self::STATUS_CONDITIONS['wo_cancel'], 'cancel_wo'),
        ];
    }

    private static function kpiCounts(?object $row): array
    {
        $counts = [];

        foreach (['total_wo', 'arrival_wo', 'on_time_wo', 'visited_wo', 'complete_wo', 'complete_24h_wo', 'cancel_wo'] as $field)
        {
            $counts[$field] = (int) ($row->{$field} ?? 0);
        }

        return $counts;
    }

    private static function kpiParts(array $counts): array
    {
        $nonCancelWo = $counts['total_wo'] - $counts['cancel_wo'];

        return [
            'otr' => [$counts['on_time_wo'], $counts['arrival_wo']],
            'vr'  => [$counts['visited_wo'], $counts['total_wo']],
            'sla' => [$counts['complete_24h_wo'], $nonCancelWo],
            'sr'  => [$counts['complete_wo'], $nonCancelWo],
        ];
    }

    public static function kpiSummary(string $startDate, string $endDate, ?string $area, ?array $woTypes): array
    {
        $row = self::baseQuery($startDate, $endDate, $area, $woTypes)
            ->leftJoin('tb_stella_workorders_detail as tswd', 'tswd.work_order_number_id', '=', 'twk.wo_number_id')
            ->select(self::kpiCountSelects())
            ->first();

        $parts      = self::kpiParts(self::kpiCounts($row));
        $percentage = fn(array $part): float => $part[1] > 0 ? round($part[0] / $part[1] * 100, 2) : 0.0;

        return [
            'on_time_rate'    => $percentage($parts['otr']),
            'on_time_formula' => "{$parts['otr'][0]} / {$parts['otr'][1]} WO Stella (ada arrival time)",
            'visit_rate'      => $percentage($parts['vr']),
            'visit_formula'   => "{$parts['vr'][0]} / {$parts['vr'][1]} WO",
            'sla24_rate'      => $percentage($parts['sla']),
            'sla24_formula'   => "{$parts['sla'][0]} / {$parts['sla'][1]} WO (non-cancel)",
            'success_rate'    => $percentage($parts['sr']),
            'success_formula' => "{$parts['sr'][0]} / {$parts['sr'][1]} WO (non-cancel)",
        ];
    }

    public static function kpiDaily(string $month): array
    {
        $firstDate = "{$month}-01";
        $lastDate  = date('Y-m-t', strtotime($firstDate));

        $rows = self::baseQuery($firstDate, $lastDate, null, self::KPI_WO_TYPES)
            ->leftJoin('tb_stella_workorders_detail as tswd', 'tswd.work_order_number_id', '=', 'twk.wo_number_id')
            ->select(array_merge(['tsw.area', 'twk.date_wo'], self::kpiCountSelects()))
            ->groupBy('tsw.area', 'twk.date_wo')
            ->get();

        $countsByAreaAndDay = [];
        $nationalCountsByDay = [];

        foreach ($rows as $row)
        {
            $area   = $row->area ?? '-';
            $day    = (int) substr($row->date_wo, 8, 2);
            $counts = self::kpiCounts($row);

            $countsByAreaAndDay[$area][$day] = $counts;

            foreach ($counts as $field => $value)
            {
                $nationalCountsByDay[$day][$field] = ($nationalCountsByDay[$day][$field] ?? 0) + $value;
            }
        }

        $toDailyRates = function (array $countsByDay): array
        {
            $dailyRates = [];

            foreach ($countsByDay as $day => $counts)
            {
                $dailyRate = ['day' => $day, 'orders' => []];

                foreach (self::kpiParts($counts) as $metric => [$part, $whole])
                {
                    $dailyRate[$metric]           = $whole > 0 ? round($part / $whole * 100, 2) : null;
                    $dailyRate['orders'][$metric] = $part;
                }

                $dailyRates[] = $dailyRate;
            }

            return $dailyRates;
        };

        ksort($countsByAreaAndDay);

        return [
            'days_in_month' => (int) date('t', strtotime($firstDate)),
            'areas'         => array_map(
                fn($area, $countsByDay) => ['area' => $area, 'days' => $toDailyRates($countsByDay)],
                array_keys($countsByAreaAndDay),
                $countsByAreaAndDay
            ),
            'national'      => $toDailyRates($nationalCountsByDay),
        ];
    }

    public static function kpiDailyDetail(string $date, ?string $area, string $metric, string $mode): array
    {
        $conditions = self::kpiMetricConditions()[$metric];
        $filter     = $mode === 'order' ? $conditions['numerator'] : $conditions['denominator'];

        return self::baseQuery($date, $date, $area, self::KPI_WO_TYPES)
            ->leftJoin('tb_stella_workorders_detail as tswd', 'tswd.work_order_number_id', '=', 'twk.wo_number_id')
            ->whereRaw($filter)
            ->select([
                'tsw.workOrderType',
                'tsw.plan',
                'twk.id_customer',
                'twk.wo_number',
                'twk.date_wo',
                'tsw.slotTime',
                'tswd.arrival_time',
                'twk.installer',
                'twk.wo_agent',
                'twk.wo_reason_agent',
                'twk.wo_installer',
                'twk.updated_at',
                DB::raw('DATE_ADD(twk.date_wo, INTERVAL 1 DAY) AS sla_deadline_date'),
                DB::raw("CASE WHEN {$conditions['numerator']} THEN 1 ELSE 0 END AS is_achieved"),
            ])
            ->orderBy('tsw.slotTime')
            ->orderBy('twk.wo_number')
            ->get()
            ->map(fn($row) => [
                'wo_type'         => $row->workOrderType ?? '-',
                'plan'            => $row->plan ?? '-',
                'id_customer'     => $row->id_customer ?? '-',
                'wo_number'       => $row->wo_number ?? '-',
                'date_wo'         => $row->date_wo ?? '-',
                'slot_time'       => $row->slotTime ?: '-',
                'arrival_time'    => $row->arrival_time ?: '-',
                'installer'       => $row->installer ?: '-',
                'wo_agent'        => $row->wo_agent ?? '-',
                'wo_reason_agent' => $row->wo_reason_agent ?? '-',
                'wo_installer'    => $row->wo_installer ?? '-',
                'updated_at'      => $row->updated_at ?? '-',
                'otr_deadline'    => preg_match('/^\d{2}:/', (string) $row->slotTime) ? substr($row->slotTime, 0, 2) . ':30:00' : '-',
                'sla_deadline'    => $row->sla_deadline_date . ' 00:00:00',
                'is_achieved'     => (bool) $row->is_achieved,
            ])
            ->toArray();
    }
}
