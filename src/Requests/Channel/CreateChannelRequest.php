<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Channel;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasFormBody;

class CreateChannelRequest extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    protected string $topicId;

    protected string $topic;

    protected ?string $description;

    protected bool $isPrivate;

    protected array $metaData;

    public function __construct(
        string $topicId,
        string $topic,
        ?string $description = null,
        bool $isPrivate = false,
        array $metaData = []
    ) {
        $this->topicId = $topicId;
        $this->topic = $topic;
        $this->description = $description;
        $this->isPrivate = $isPrivate;
        $this->metaData = $metaData;
    }

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        // TODO: Implement resolveEndpoint() method.
    }

    protected function defaultBody(): array
    {
        return [
            'topic_id' => $this->topicId,
            'topic' => $this->topic,
            'description' => $this->description,
            'is_private' => $this->isPrivate,
            'meta_data' => $this->metaData,
        ];
    }
}
