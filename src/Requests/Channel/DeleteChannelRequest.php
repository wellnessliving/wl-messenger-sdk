<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Channel;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteChannelRequest extends Request
{
    protected Method $method = Method::DELETE;

    protected string|int $channelId;

    public function __construct(string|int $channelId)
    {
        $this->channelId = $channelId;
    }

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return '/channels/' . $this->channelId;
    }
}
