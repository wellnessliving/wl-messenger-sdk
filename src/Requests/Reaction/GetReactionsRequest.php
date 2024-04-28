<?php

namespace WellnessLiving\MessengerSdk\Requests\Reaction;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetReactionsRequest extends Request
{
    protected string $reactionId;

    protected Method $method = Method::GET;

    public function __construct(string $reactionId)
    {
        $this->reactionId = $reactionId;
    }

    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return '/reactions';
    }

    protected function defaultQuery(): array
    {
        return [
            'reactionable_id' => $this->reactionId,
        ];
    }
}