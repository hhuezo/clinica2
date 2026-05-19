<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Clinic::with(['department', 'district', 'branches'])->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'legal_name' => 'nullable|string|max:255',
            'nit' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'address' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'district_id' => 'nullable|exists:districts,id',
        ]);

        $clinic = Clinic::create($data);

        return response()->json($clinic, 201);
    }

    public function storeBranch(Request $request, Clinic $clinic): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'district_id' => 'nullable|exists:districts,id',
            'is_main' => 'boolean',
        ]);

        $branch = $clinic->branches()->create($data);

        return response()->json($branch, 201);
    }

    public function storeDoctor(Request $request): JsonResponse
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id|unique:doctors,user_id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'specialty' => 'nullable|string|max:150',
            'license_number' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:30',
            'bio' => 'nullable|string',
            'branch_ids' => 'nullable|array',
            'branch_ids.*' => 'exists:branches,id',
        ]);

        $doctor = DB::transaction(function () use ($data) {
            $branchIds = $data['branch_ids'] ?? [];
            unset($data['branch_ids']);

            $doctor = Doctor::create($data);

            if ($branchIds) {
                $doctor->branches()->sync($branchIds);
            }

            $doctor->user->assignRole('doctor');

            return $doctor->load('branches', 'user');
        });

        return response()->json($doctor, 201);
    }

    public function doctors(): JsonResponse
    {
        return response()->json(
            Doctor::with(['user', 'branches.clinic'])->where('is_active', true)->get()
        );
    }

    public function branches(): JsonResponse
    {
        return response()->json(
            Branch::with('clinic')->where('is_active', true)->get()
        );
    }
}
