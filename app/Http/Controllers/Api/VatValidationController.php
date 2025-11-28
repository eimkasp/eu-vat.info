<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ViesValidationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VatValidationController extends Controller
{
    public function __construct(
        private ViesValidationService $viesService
    ) {}

    /**
     * Validate VAT number via API
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function validate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'country_code' => 'required|string|size:2',
            'vat_number' => 'required|string|min:5|max:50',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $result = $this->viesService->validate(
            $validated['country_code'],
            $validated['vat_number'],
            $validated['company_name'] ?? null,
            $validated['address'] ?? null
        );

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }

    /**
     * Batch validate multiple VAT numbers
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function batchValidate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'validations' => 'required|array|min:1|max:10',
            'validations.*.country_code' => 'required|string|size:2',
            'validations.*.vat_number' => 'required|string|min:5|max:50',
            'validations.*.company_name' => 'nullable|string|max:255',
            'validations.*.address' => 'nullable|string|max:500',
        ]);

        $results = [];
        foreach ($validated['validations'] as $validation) {
            $results[] = $this->viesService->validate(
                $validation['country_code'],
                $validation['vat_number'],
                $validation['company_name'] ?? null,
                $validation['address'] ?? null
            );
        }

        return response()->json([
            'success' => true,
            'data' => $results,
            'total' => count($results),
        ]);
    }

    /**
     * Health check endpoint
     * 
     * @return JsonResponse
     */
    public function health(): JsonResponse
    {
        return response()->json([
            'status' => 'operational',
            'service' => 'VAT VIES Validation API',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
