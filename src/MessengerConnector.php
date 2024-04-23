<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\PendingRequest;
use WellnessLiving\MessengerSdk\Requests\Authentication\GetTokenRequest;
use WellnessLiving\MessengerSdk\Requests\Channel\ChannelResource;
use WellnessLiving\MessengerSdk\Requests\ChannelUser\ChannelUserResource;
use WellnessLiving\MessengerSdk\Requests\Message\MessageResource;

class MessengerConnector extends Connector
{
    public string $baseUrl;

    public string $internalAccessKey;

    public string|int|null $businessId;

    public string|int|null $userId;

    public string $apiVersion;

    public ?string $accessToken = null;

    public function __construct(
        $baseUrl,
        $internalAccessKey,
        string|int|null $businessId = null,
        string|int|null $userId = null,
        ?string $accessToken = null,
        string $apiVersion = 'v1'
    ) {
        $this->baseUrl = $baseUrl;
        $this->internalAccessKey = $internalAccessKey;
        $this->businessId = $businessId;
        $this->userId = $userId;
        $this->apiVersion = $apiVersion;
        $this->accessToken = $accessToken;
    }

    public function boot(PendingRequest $pendingRequest): void
    {
        // Let's start by returning early if the request being sent is the
        // GetAccessTokenRequest. We don't want to create an infinite loop

        if ($pendingRequest->getRequest() instanceof GetTokenRequest) {
            return;
        }

        // Now let's make our authentication request. Since we are in the
        // context of the connector, we can just simply call $this and
        // make another request!

        // Lets generate a token
        $token = hash(
            'sha256',
            implode(':', [
                'business_id' => $this->businessId,
                'user_id' => $this->userId,
                'signature' => config('wl-messenger.messenger_access_key'),
            ])
        );

        $authResponse = $this->send(new GetTokenRequest($this->internalAccessKey, $this->businessId, $this->userId));

        // Now we'll take the token from the auth response and then pass it
        // into the $pendingRequest which is the original GetSongsByArtistRequest.

        $pendingRequest->authenticate(new TokenAuthenticator($authResponse->json()['data']['access_token']));
    }

    /**
     * {@inheritDoc}
     */
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl . "/api/{$this->apiVersion}";
    }

    public function setBusinessId(int|string|null $businessId): MessengerConnector
    {
        $this->businessId = $businessId;

        return $this;
    }

    public function setUserId(int|string|null $userId): MessengerConnector
    {
        $this->userId = $userId;

        return $this;
    }

    public function getBusinessId(): int|string|null
    {
        return $this->businessId;
    }

    public function getUserId(): int|string|null
    {
        return $this->userId;
    }

    public function channel(): ChannelResource
    {
        return new ChannelResource($this);
    }

    public function message(): MessageResource
    {
        return new MessageResource($this);
    }

    public function channelUser(): ChannelUserResource
    {
        return new ChannelUserResource($this);
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
