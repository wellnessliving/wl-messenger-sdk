<?php

namespace WellnessLiving\MessengerSdk\Requests\Reaction;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasFormBody;
use WellnessLiving\MessengerSdk\Enums\ReactionType;

class CreateReactionRequest extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    protected ReactionType $reactionType;
    protected string $reactionId;

    protected string $reactedBy;

    protected string $reaction;

    public function __construct(ReactionType $reactionType, string $reactionId, string $reactedBy, string $reaction)
    {
        $this->reactionType = $reactionType;
        $this->reactionId = $reactionId;
        $this->reactedBy = $reactedBy;
        $this->reaction = $reaction;
    }

    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return "/reactions";
    }

    protected function defaultBody()
    {
        return [
            'reactionable_type' => $this->reactionType->value,
            'reactionable_id' => $this->reactionId,
            'reacted_by' => $this->reactedBy,
            'reaction' => $this->reaction,
        ];

    }
}