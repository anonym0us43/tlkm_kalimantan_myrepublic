<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\AreaModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        return view('administrator.area');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code'    => ['nullable', 'integer'],
            'initial' => ['nullable', 'string', 'max:3'],
            'name'    => ['required', 'string', 'max:100', 'unique:tb_area,name'],
        ]);

        AreaModel::create($validated);

        return response()->json(['message' => 'Area berhasil ditambahkan.']);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(AreaModel::select('id', 'code', 'initial', 'name')->findOrFail($id));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $area = AreaModel::findOrFail($id);

        $validated = $request->validate([
            'code'    => ['nullable', 'integer'],
            'initial' => ['nullable', 'string', 'max:3'],
            'name'    => ['required', 'string', 'max:100', 'unique:tb_area,name,' . $id],
        ]);

        $area->update($validated);

        return response()->json(['message' => 'Area berhasil diperbarui.']);
    }

    public function destroy(int $id): JsonResponse
    {
        $area = AreaModel::findOrFail($id);

        if ($area->employees()->exists())
        {
            return response()->json(['message' => 'Area tidak dapat dihapus karena masih digunakan oleh employee.'], 422);
        }

        $area->delete();

        return response()->json(['message' => 'Area berhasil dihapus.']);
    }
}
