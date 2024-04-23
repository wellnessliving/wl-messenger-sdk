<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Message;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetMessagesRequest extends Request
{
    protected string $channelId;

    protected Method $method = Method::GET;

    public function __construct(string $channelId)
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

    protected function defaultQuery(): array
    {
        return [
            'channel_id' => $this->channelId,
        ];
    }
}
