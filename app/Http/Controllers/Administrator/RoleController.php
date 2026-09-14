<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\RoleModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('administrator.role');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:tb_role,name'],
        ]);

        RoleModel::create($validated);

        return response()->json(['message' => 'Role berhasil ditambahkan.']);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(RoleModel::findOrFail($id));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $role = RoleModel::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:tb_role,name,' . $id],
        ]);

        $role->update($validated);

        return response()->json(['message' => 'Role berhasil diperbarui.']);
    }

    public function destroy(int $id): JsonResponse
    {
        $role = RoleModel::findOrFail($id);

        if ($role->employees()->exists())
        {
            return response()->json(['message' => 'Role tidak dapat dihapus karena masih digunakan oleh employee.'], 422);
        }

        $role->delete();

        return response()->json(['message' => 'Role berhasil dihapus.']);
    }
}
