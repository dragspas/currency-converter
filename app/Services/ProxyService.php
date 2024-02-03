<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;

class ProxyService implements IProxyService
{
    public function get(string $url, array $queryParams = [], bool $retry = false): Response
    {
        if ($retry) {
            return $this->retry()
                ->withQueryParameters($queryParams)
                ->get($url);
        } else {
            return Http::get($url, $queryParams);
        }
    }

    protected function retry(): PendingRequest
    {
        return Http::retry(5, 1000, function (\Exception $exception) {
            Log::warning('Proxy error.', ['message' => $exception->getMessage()]);

            if (!$exception instanceof RequestException || $exception->response->status() !== 401) {
                return false;
            }

            // @note
            // we could do here a refresh token and return true

            return false;
        });
    }
}
