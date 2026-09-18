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

    public static function kpiSummary(string $startDate, string $endDate, ?string $area, ?array $woTypes): array
    {
        $status = self::STATUS_CONDITIONS;

        $isClosed  = "({$status['wo_cancel']} OR {$status['wo_complete']})";
        $isVisited = "({$status['verification_agent']} OR {$status['wo_pending']} OR {$isClosed})"
            . ' AND NOT ' . self::IS_NOT_VISITED;
        $isClosedWithin24h = "{$isClosed} AND twk.updated_at <= DATE_ADD(twk.date_wo, INTERVAL 1 DAY)";

        $row = self::baseQuery($startDate, $endDate, $area, $woTypes)
            ->leftJoin('tb_stella_workorders_detail as tswd', 'tswd.work_order_number_id', '=', 'twk.wo_number_id')
            ->select([
                DB::raw('COUNT(*) AS total_wo'),
                DB::raw('COUNT(tswd.id) AS stella_wo'),
                DB::raw('SUM(CASE WHEN tswd.is_on_time = 1 THEN 1 ELSE 0 END) AS on_time_wo'),
                self::countWhen($isVisited, 'visited_wo'),
                self::countWhen($isClosed, 'closed_wo'),
                self::countWhen($isClosedWithin24h, 'closed_24h_wo'),
            ])
            ->first();

        $totalWo     = (int) ($row->total_wo ?? 0);
        $stellaWo    = (int) ($row->stella_wo ?? 0);
        $onTimeWo    = (int) ($row->on_time_wo ?? 0);
        $visitedWo   = (int) ($row->visited_wo ?? 0);
        $closedWo    = (int) ($row->closed_wo ?? 0);
        $closed24hWo = (int) ($row->closed_24h_wo ?? 0);

        $percentage = fn(int $part, int $whole): float => $whole > 0 ? round($part / $whole * 100, 2) : 0.0;

        return [
            'on_time_rate'    => $percentage($onTimeWo, $stellaWo),
            'on_time_formula' => "{$onTimeWo} / {$stellaWo} WO Stella",
            'visit_rate'      => $percentage($visitedWo, $totalWo),
            'visit_formula'   => "{$visitedWo} / {$totalWo} WO",
            'sla24_rate'      => $percentage($closed24hWo, $totalWo),
            'sla24_formula'   => "{$closed24hWo} / {$totalWo} WO",
            'success_rate'    => $percentage($closedWo, $totalWo),
            'success_formula' => "{$closedWo} / {$totalWo} WO",
        ];
    }
}
