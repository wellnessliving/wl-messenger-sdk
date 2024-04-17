<?php

namespace WellnessLiving\MessengerSdk\Requests\Message;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetMessagesRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return '/messages';
    }
}