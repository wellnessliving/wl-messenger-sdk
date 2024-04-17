<?php

namespace WellnessLiving\MessengerSdk;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\OAuth2\GetAccessTokenRequest;
use Saloon\Http\PendingRequest;

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


    public function boot(PendingRequest $pendingRequest): void
    {
        // Let's start by returning early if the request being sent is the
        // GetAccessTokenRequest. We don't want to create an infinite loop

        if ($pendingRequest->getRequest() instanceof GetAccessTokenRequest) {
            return;
        }


        // Now let's make our authentication request. Since we are in the
        // context of the connector, we can just simply call $this and
        // make another request!

        $authResponse = $this->send(new GetTokenRequest($this->internalAccessKey, $this->businessId, $this->userId));

        // Now we'll take the token from the auth response and then pass it
        // into the $pendingRequest which is the original GetSongsByArtistRequest.

        $pendingRequest->authenticate(new TokenAuthenticator($authResponse->json()['data']['access_token']));
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