<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Message;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class MessageResource extends BaseResource
{
    public function all(string $channelId): Response
    {
        return $this->connector->send(new GetMessagesRequest($channelId));
    }

    public function create(
        string $channelId,
        string $message
    ): Response {
        return $this->connector->send(new CreateMessageRequest($channelId, $message));
    }

    public function update(
        string $messageId,
        string $message
    ): Response {
        return $this->connector->send(new UpdateMessageRequest($messageId, $message));
    }

    public function delete(string $messageId): Response
    {
        return $this->connector->send(new DeleteMessageRequest($messageId));
    }
}
