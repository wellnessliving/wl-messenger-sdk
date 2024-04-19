<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Channel;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateChannelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

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
