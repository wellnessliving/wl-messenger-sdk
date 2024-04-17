<?php

namespace WellnessLiving\MessengerSdk\Requests\Channel;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetChannelsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return '/channels';
    }
}