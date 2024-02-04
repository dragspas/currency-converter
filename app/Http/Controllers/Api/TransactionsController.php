<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetTransactionsCalculateRequest;
use App\Http\Requests\PostTransactionsRequest;
use App\Services\IConversionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TransactionsController extends Controller
{
    private IConversionService $conversionService;

    public function __construct(IConversionService $conversionService)
    {
        $this->conversionService = $conversionService;
    }

    public function store(PostTransactionsRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $transaction = $this->conversionService->convertFromDefault($validated['to_currency_id'], $validated['amount'], true);

            return $this->getSuccessResponse(['transaction' => $transaction], 200, 'Transaction created successfully.');
        } catch (\Exception $exception) {
            Log::error('POST /api/v1/transactions failed.', [
                ...$validated,
                'message' => $exception->getMessage(),
            ]);

            return $this->getErrorResponse($exception->getCode(), $exception->getMessage());
        }
    }

    public function calculate(GetTransactionsCalculateRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $transaction = $this->conversionService->convertFromDefault($validated['to_currency_id'], $validated['amount']);

            return $this->getSuccessResponse(['amount' => $transaction->amountPaidUsd]);
        } catch (\Exception $exception) {
            Log::error('GET /api/v1/transactions/calculate failed.', [
                ...$validated,
                'message' => $exception->getMessage(),
            ]);

            return $this->getErrorResponse($exception->getCode(), $exception->getMessage());
        }
    }
}
