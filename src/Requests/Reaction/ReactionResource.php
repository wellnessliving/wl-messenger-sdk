<?php

namespace WellnessLiving\MessengerSdk\Requests\Reaction;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use WellnessLiving\MessengerSdk\Enums\ReactionType;

class ReactionResource extends BaseResource
{
    public function all(string $reactionId): Response
    {
        return $this->connector->send(new GetReactionsRequest($reactionId));
    }

    public function create(
        ReactionType $reactionType,
        string       $reactionId,
        string       $reactedBy,
        string       $reaction,
    ): Response
    {
        return $this->connector->send(new CreateReactionRequest($reactionType, $reactionId, $reactedBy, $reaction));
    }

    public function delete(string $reactionId): Response
    {
        return $this->connector->send(new DeleteReactionRequest($reactionId));
    }
}