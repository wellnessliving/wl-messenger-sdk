<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Channel;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateChannelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    protected string $topicId;

    protected string $topic;

    protected ?string $description;

    protected bool $isPrivate = false;

    protected array $metaData = [];

    public function __construct(array $attributes)
    {
        $this->topicId = $attributes['topic_id'];
        $this->topic = $attributes['topic'];
    }

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return '/channels';
    }

    protected function defaultBody(): array
    {
        return [
            'topic_id' => $this->topicId,
            'topic' => $this->topic,
            'is_private' => $this->isPrivate,
            'meta_data' => $this->metaData,
        ];
    }
}
