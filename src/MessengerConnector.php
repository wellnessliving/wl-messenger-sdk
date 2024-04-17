<?php

namespace WellnessLiving\MessengerSdk;

use Saloon\Http\Connector;

class MessengerConnector extends Connector
{
    public string $baseUrl;
    public string $internalAccessKey;

    public string|int|null $businessId;
    public string|int|null $userId;

    public function __construct($baseUrl, $internalAccessKey, string|int|null $businessId = null, string|int|null $userId = null)
    {
        $this->baseUrl = $baseUrl;
        $this->internalAccessKey = $internalAccessKey;
        $this->businessId = $businessId;
        $this->userId = $userId;
    }
    /**
     * @inheritDoc
     */
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}