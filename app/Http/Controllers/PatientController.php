<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Services\PatientRegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(
        protected PatientRegistrationService $registrationService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $patients = Patient::with(['documentType', 'department', 'district', 'primaryGuardian.kinship'])
            ->when($request->search, function ($q, $search) {
                $q->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('document_number', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15);

        return response()->json($patients);
    }

    public function store(Request $request): JsonResponse
    {
        $minor = $this->registrationService->isMinor($request->input('birth_date', now()));

        $rules = [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:M,F,O',
            'document_type_id' => 'required|exists:document_types,id',
            'document_number' => 'required|string|max:50',
            'country_id' => 'nullable|exists:countries,id',
            'department_id' => 'nullable|exists:departments,id',
            'district_id' => 'nullable|exists:districts,id',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string',
        ];

        if ($minor) {
            $rules += [
                'guardian.kinship_id' => 'required|exists:kinships,id',
                'guardian.first_name' => 'required|string|max:100',
                'guardian.last_name' => 'required|string|max:100',
                'guardian.document_type_id' => 'required|exists:document_types,id',
                'guardian.document_number' => 'required|string|max:50',
                'guardian.phone' => 'nullable|string|max:30',
                'guardian.email' => 'nullable|email|max:255',
                'guardian.address' => 'nullable|string',
            ];
        }

        $validated = $request->validate($rules);

        $patientData = collect($validated)->except('guardian')->toArray();
        $patientData['registered_by'] = $request->user()?->id;

        $guardianData = $validated['guardian'] ?? null;

        $patient = $this->registrationService->register($patientData, $guardianData);

        return response()->json($patient, 201);
    }

    public function show(Patient $patient): JsonResponse
    {
        $patient->load([
            'documentType',
            'country',
            'department',
            'district',
            'guardians.kinship',
            'guardians.documentType',
            'appointments.doctor',
            'medicalRecords.doctor',
        ]);

        return response()->json($patient);
    }
}
