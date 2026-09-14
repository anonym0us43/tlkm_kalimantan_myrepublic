<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
    protected $table = 'tb_area';

    const CREATED_AT = null;

    protected $fillable = ['code', 'initial', 'name'];

    public function employees()
    {
        return $this->hasMany(EmployeeModel::class, 'area_id');
    }

    public static function tableData(): array
    {
        return self::select('id', 'code', 'initial', 'name', 'updated_at')
            ->orderBy('name')
            ->get()
            ->map(function ($row, $index)
            {
                return [
                    'no'      => $index + 1,
                    'id'      => $row->id,
                    'code'    => e($row->code ?? '-'),
                    'initial' => e($row->initial ?? '-'),
                    'name'    => e($row->name),
                    'updated' => $row->updated_at?->format('d/m/Y'),
                ];
            })
            ->toArray();
    }
}
