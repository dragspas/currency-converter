<?php

namespace App\Services;

use Illuminate\Http\Client\Response;

interface IProxyService
{
    public function get(string $url): Response;
}
