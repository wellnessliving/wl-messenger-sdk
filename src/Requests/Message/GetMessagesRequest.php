<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Message;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetMessagesRequest extends Request
{
    protected string $channelId;

    protected Method $method = Method::GET;

    public function __construct(?string $channelId = null)
    {
        $this->channelId = $channelId;
    }

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return '/messages';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultQuery(): array
    {
        return [
            'channel_id' => $this->channelId,
        ];
    }
}
