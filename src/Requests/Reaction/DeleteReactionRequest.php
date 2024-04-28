<?php

namespace WellnessLiving\MessengerSdk\Requests\Reaction;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteReactionRequest extends Request
{

    protected Method $method = Method::DELETE;

    protected string $reactionId;


    public function __construct(string $reactionId)
    {
        $this->reactionId = $reactionId;
    }

    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return '/reactions/' . $this->reactionId;
    }
}