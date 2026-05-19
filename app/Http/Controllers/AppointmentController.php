<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $appointments = Appointment::with(['patient', 'doctor', 'branch.clinic'])
            ->when($request->date, fn ($q, $date) => $q->whereDate('scheduled_at', $date))
            ->when($request->doctor_id, fn ($q, $id) => $q->where('doctor_id', $id))
            ->when($request->branch_id, fn ($q, $id) => $q->where('branch_id', $id))
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->orderBy('scheduled_at')
            ->paginate(20);

        return response()->json($appointments);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'branch_id' => 'required|exists:branches,id',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'nullable|integer|min:15|max:240',
            'reason' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $data['created_by'] = $request->user()?->id;
        $data['duration_minutes'] ??= 30;

        $appointment = Appointment::create($data);

        return response()->json($appointment->load(['patient', 'doctor', 'branch']), 201);
    }

    public function update(Request $request, Appointment $appointment): JsonResponse
    {
        $data = $request->validate([
            'scheduled_at' => 'sometimes|date',
            'duration_minutes' => 'nullable|integer|min:15|max:240',
            'status' => 'sometimes|in:pending,confirmed,in_progress,completed,cancelled,no_show',
            'reason' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($data);

        return response()->json($appointment->fresh(['patient', 'doctor', 'branch']));
    }
}
