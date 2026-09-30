<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class AuthModel extends Authenticatable
{
    use HasFactory, Notifiable;

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public static function profile(): ?self
    {
        return self::select('tb_employee.*', 'tb_area.name as area_name', 'tb_role.name as role_name')
            ->join('tb_area', 'tb_employee.area_id', '=', 'tb_area.id')
            ->join('tb_role', 'tb_employee.role_id', '=', 'tb_role.id')
            ->where('tb_employee.id', Auth::id())
            ->first();
    }

    public function isAdministrator(): bool
    {
        return (int) $this->role_id === RoleModel::ADMINISTRATOR_ID;
    }
}
