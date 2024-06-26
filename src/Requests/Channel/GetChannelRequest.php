<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Channel;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetChannelRequest extends Request
{
    protected Method $method = Method::GET;

    protected string|int $id;

    public function __construct(string|int $channelId)
    {
        $this->id = $channelId;
    }

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return '/channels/' . $this->id;
    }
}
