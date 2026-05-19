<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Department;
use App\Models\District;
use App\Models\DocumentType;
use App\Models\Kinship;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function countries(): JsonResponse
    {
        return response()->json(
            Country::where('is_active', true)->orderBy('name')->get(['id', 'name', 'iso_code', 'phone_code'])
        );
    }

    public function departments(Request $request): JsonResponse
    {
        $query = Department::where('is_active', true)->orderBy('name');

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->integer('country_id'));
        }

        return response()->json($query->get(['id', 'country_id', 'name', 'code']));
    }

    public function districts(Request $request): JsonResponse
    {
        $request->validate(['department_id' => 'required|exists:departments,id']);

        return response()->json(
            District::where('department_id', $request->integer('department_id'))
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'department_id', 'name', 'code'])
        );
    }

    public function documentTypes(Request $request): JsonResponse
    {
        $query = DocumentType::where('is_active', true)->orderBy('name');

        if ($request->boolean('for_minors')) {
            $query->forMinors();
        } elseif ($request->boolean('for_adults')) {
            $query->forAdults();
        }

        return response()->json($query->get(['id', 'name', 'code', 'for_adults', 'for_minors']));
    }

    public function kinships(): JsonResponse
    {
        return response()->json(
            Kinship::where('is_active', true)->orderBy('name')->get(['id', 'name', 'code'])
        );
    }
}
