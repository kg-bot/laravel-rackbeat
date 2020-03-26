<?php


namespace Rackbeat\Utils;


use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Spatie\GuzzleRateLimiterMiddleware\Store;

class RateLimiterStore implements Store
{
    public function get(): array
    {
        return Cache::get('rate-limiter', []);
    }

    public function push(int $timestamp)
    {
        Cache::put('rate-limiter', array_merge($this->get(), [$timestamp]), Carbon::now()->addMinute());
    }
}