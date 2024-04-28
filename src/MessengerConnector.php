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
use WellnessLiving\MessengerSdk\Requests\Reaction\ReactionResource;

class MessengerConnector extends Connector
{
    public string $baseUrl;

    public string $signatureKey;

    /** @var string|int|null */
    public $businessId;

    /** @var string|int|null */
    public $userId;

    public string $apiVersion;

    public function __construct(
        $baseUrl,
        $signatureKey,
        string $apiVersion,
        string $businessId = null,
        string $userId = null,
    )
    {
        $this->baseUrl = $baseUrl;
        $this->signatureKey = $signatureKey;
        $this->apiVersion = $apiVersion;
        $this->businessId = $businessId;
        $this->userId = $userId;
    }

    public function boot(PendingRequest $pendingRequest): void
    {
        if (!$this->businessId) {
            throw new \Exception('Missing Business Id');
        }

        if (!$this->userId) {
            throw new \Exception('Missing User ID');
        }

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
                'signature' => $this->signatureKey,
            ])
        );

        $authResponse = $this->send(new GetTokenRequest($token, $this->businessId, $this->userId));

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


    public function channel(): ChannelResource
    {
        return new ChannelResource($this);
    }

    public function message(): MessageResource
    {
        return new MessageResource($this);
    }

    public function reaction(): ReactionResource
    {
        return new ReactionResource($this);
    }

    public function channelUser(): ChannelUserResource
    {
        return new ChannelUserResource($this);
    }

    public function setBusinessId(int|string $businessId): MessengerConnector
    {
        $this->businessId = $businessId;
        return $this;
    }

    public function setUserId(int|string $userId): MessengerConnector
    {
        $this->userId = $userId;
        return $this;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
