<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\PendingRequest;
use WellnessLiving\MessengerSdk\Requests\Authentication\GetTokenRequest;
use WellnessLiving\MessengerSdk\Requests\Channel\CreateChannelRequest;
use WellnessLiving\MessengerSdk\Requests\Channel\GetChannelRequest;
use WellnessLiving\MessengerSdk\Requests\Channel\GetChannelsRequest;
use WellnessLiving\MessengerSdk\Requests\Message\CreateMessageRequest;
use WellnessLiving\MessengerSdk\Requests\Message\DeleteMessageRequest;
use WellnessLiving\MessengerSdk\Requests\Message\GetMessagesRequest;
use WellnessLiving\MessengerSdk\Requests\Message\UpdateMessageRequest;

class MessengerConnector extends Connector
{
    public string $baseUrl;

    public string $internalAccessKey;

    public string|int|null $businessId;

    public string|int|null $userId;

    public string $apiVersion;

    public function __construct($baseUrl, $internalAccessKey, string|int|null $businessId = null, string|int|null $userId = null, string $apiVersion = 'v1')
    {
        $this->baseUrl = $baseUrl;
        $this->internalAccessKey = $internalAccessKey;
        $this->businessId = $businessId;
        $this->userId = $userId;
        $this->apiVersion = $apiVersion;
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

    public function allChannel()
    {
        return $this->send(new GetChannelsRequest());
    }

    public function getChannel(string $channelId)
    {
        return $this->send(new GetChannelRequest($channelId));
    }

    public function createChannel(
        string $topicId,
        string $topic,
        ?string $description = null,
        bool $isPrivate = false,
        array $metaData = []
    ) {
        return $this->send(new CreateChannelRequest($topicId, $topic, $description, $isPrivate, $metaData));
    }

    public function getMessages(string $channelId)
    {
        return $this->send(new GetMessagesRequest($channelId));
    }

    public function createMessage(string $message, string $channelId)
    {
        return $this->send(new CreateMessageRequest($message, $channelId));
    }

    public function updateMessage(string $message, string $channelId)
    {
        return $this->send(new UpdateMessageRequest($message, $channelId));
    }

    public function deleteMessage(string $messageId)
    {
        return $this->send(new DeleteMessageRequest($messageId));
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
