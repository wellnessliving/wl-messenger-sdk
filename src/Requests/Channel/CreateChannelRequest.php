<?php

namespace WellnessLiving\MessengerSdk\Requests\Channel;

use Saloon\Contracts\Body\BodyRepository;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasFormBody;

class CreateChannelRequest extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;
    private string $topicId;
    private string $topic;
    private ?string $description;
    private bool $isPrivate;
    private array $metaData;

    public function __construct(
        string $topicId,
        string $topic,
        string $description = null,
        bool   $isPrivate = false,
        array  $metaData = []
    )
    {
        $this->topicId = $topicId;
        $this->topic = $topic;
        $this->description = $description;
        $this->isPrivate = $isPrivate;
        $this->metaData = $metaData;
    }

    protected function defaultBody(): array
    {
        return [
            'topic_id' => $this->topicId,
            'topic' => $this->topic,
            'description' => $this->description,
            'is_private' => $this->isPrivate,
            'meta_data' => $this->metaData
        ];
    }


    /**
     * @inheritDoc
     */
    public function body(): BodyRepository
    {
        // TODO: Implement body() method.
    }

    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        // TODO: Implement resolveEndpoint() method.
    }
}