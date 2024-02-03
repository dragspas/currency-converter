<?php

namespace App\Http\Controllers\Api;

use App\Enums\Db\Flag;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetCurrenciesConvertRequest;
use App\Http\Requests\GetCurrenciesRequest;
use App\Services\ICurrenciesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CurrenciesController extends Controller
{
    private ICurrenciesService $currenciesService;

    public function __construct(ICurrenciesService $currenciesService)
    {
        $this->currenciesService = $currenciesService;
    }

    public function get(GetCurrenciesRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $currencies = $this->currenciesService->getAllByDefault(Flag::from($validated['default']));

            return $this->getSuccessResponse($currencies);
        } catch (\Exception $exception) {
            Log::error('GET /api/v1/currencies failed.', [
                ...$validated,
                'message' => $exception->getMessage(),
            ]);

            return $this->getErrorResponse($exception->getCode(), $exception->getMessage());
        }
    }

    public function convert(GetCurrenciesConvertRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $convertedAmount = $this->currenciesService->convertFromDefault($validated['to_currency_id'], $validated['amount']);

            return $this->getSuccessResponse(['amount' => $convertedAmount]);
        } catch (\Exception $exception) {
            Log::error('GET /api/v1/currencies/convert failed.', [
                ...$validated,
                'message' => $exception->getMessage(),
            ]);

            return $this->getErrorResponse($exception->getCode(), $exception->getMessage());
        }
    }
}
