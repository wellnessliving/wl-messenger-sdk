<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\ChannelUser;

use Saloon\Http\Request;

class GetChannelUsersRequest extends Request
{
    protected string $channelId;

    public function __construct(string $channelId)
    {
        $this->channelId = $channelId;
    }

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return "/channels/{$this->channelId}/users";
    }
}
