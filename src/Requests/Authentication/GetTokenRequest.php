<?php

namespace WellnessLiving\MessengerSdk\Requests\Authentication;

use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Enums\Method;
use Saloon\Http\PendingRequest;
use Saloon\Http\Request;

class GetTokenRequest extends Request implements Cacheable
{

    use HasCaching;

    protected Method $method = Method::GET;

    protected string|int $businessId;

    protected string|int $userId;

    protected string $accessKey;

    public function __construct($accessKey, $businessId, $userId)
    {
        $this->accessKey = $accessKey;
        $this->businessId = $businessId;
        $this->userId = $userId;
    }


    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return 'api/v1/authentication/token';
    }

    public function defaultHeaders(): array
    {
        return [
            'X-ACCESS-KEY' => $this->accessKey
        ];
    }

    public function defaultQuery(): array
    {
        return [
            'business_id' => $this->businessId,
            'user_id' => $this->userId,
        ];
    }


    public function resolveCacheDriver(): Driver
    {
        return new LaravelCacheDriver(Cache::getStore());
    }

    public function cacheExpiryInSeconds(): int
    {
        return 60 * 30; // 30 Min
    }

    protected function cacheKey(PendingRequest $pendingRequest): ?string
    {
        dd($pendingRequest);
        return 'custom-cache-key';
    }
}