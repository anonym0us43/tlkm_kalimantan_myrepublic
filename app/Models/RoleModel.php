<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $table = 'tb_role';

    protected $fillable = ['name'];

    public function employees()
    {
        return $this->hasMany(EmployeeModel::class, 'role_id');
    }

    public static function tableData(): array
    {
        return self::select('id', 'name', 'created_at')
            ->orderBy('name')
            ->get()
            ->map(function ($row, $index)
            {
                return [
                    'no'      => $index + 1,
                    'id'      => $row->id,
                    'name'    => e($row->name),
                    'created' => $row->created_at?->format('d/m/Y'),
                ];
            })
            ->toArray();
    }
}
