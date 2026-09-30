<?php

namespace App\Models\Concerns;

trait FormatsAuditStamp
{
    protected static function auditStamp($timestamp, ?string $actorNik = null): string
    {
        if (!$timestamp)
        {
            return '-';
        }

        $stamp = e($timestamp->format('d/m/Y H:i'));

        if ($actorNik)
        {
            $stamp .= '<br><small class="text-muted">' . e($actorNik) . '</small>';
        }

        return $stamp;
    }
}
