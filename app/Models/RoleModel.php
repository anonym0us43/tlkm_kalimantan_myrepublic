<?php

namespace App\Models;

use App\Models\Concerns\FormatsAuditStamp;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use FormatsAuditStamp;

    public const ADMINISTRATOR_ID = 1;

    protected $table = 'tb_role';

    protected $fillable = ['name', 'created_by', 'updated_by'];

    public function employees()
    {
        return $this->hasMany(EmployeeModel::class, 'role_id');
    }

    public static function tableData(): array
    {
        return self::select('id', 'name', 'created_by', 'created_at', 'updated_by', 'updated_at')
            ->orderBy('name')
            ->get()
            ->map(function ($row, $index)
            {
                return [
                    'no'      => $index + 1,
                    'id'      => $row->id,
                    'name'    => e($row->name),
                    'created' => self::auditStamp($row->created_at, $row->created_by),
                    'updated' => self::auditStamp($row->updated_at, $row->updated_by),
                ];
            })
            ->toArray();
    }
}
