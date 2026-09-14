<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    protected $table = 'tb_employee';

    protected $fillable = [
        'area_id',
        'role_id',
        'nik',
        'nama',
        'status',
        'ip_address',
        'password',
        'created_by',
        'updated_by',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    public function area()
    {
        return $this->belongsTo(AreaModel::class, 'area_id');
    }

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id');
    }

    public static function tableData(): array
    {
        return self::select(
            'tb_employee.id',
            'tb_employee.nik',
            'tb_employee.nama',
            'tb_employee.status',
            'tb_employee.created_at',
            'tb_area.name as area_name',
            'tb_role.name as role_name'
        )
        ->join('tb_area', 'tb_employee.area_id', '=', 'tb_area.id')
        ->join('tb_role', 'tb_employee.role_id', '=', 'tb_role.id')
        ->orderBy('tb_employee.nama')
        ->get()
        ->map(function ($row, $index)
        {
            $badge = $row->status
                ? '<span class="badge badge-light-success">Aktif</span>'
                : '<span class="badge badge-light-danger">Non-Aktif</span>';

            return [
                'no'        => $index + 1,
                'id'        => $row->id,
                'nik'       => e($row->nik),
                'nama'      => e($row->nama),
                'area_name' => e($row->area_name),
                'role_name' => e($row->role_name),
                'status'    => $badge,
                'created'   => $row->created_at?->format('d/m/Y'),
            ];
        })
        ->toArray();
    }
}
