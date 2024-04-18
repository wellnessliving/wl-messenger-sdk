<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Authentication;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetTokenRequest extends Request
{
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
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return 'api/v1/authentication/token';
    }

    public function defaultHeaders(): array
    {
        return [
            'X-ACCESS-KEY' => $this->accessKey,
        ];
    }

    public function defaultQuery(): array
    {
        return [
            'business_id' => $this->businessId,
            'user_id' => $this->userId,
        ];
    }
}
