<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Message;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasFormBody;

class CreateMessageRequest extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    protected string $message;

    protected string $channelId;

    public function __construct(string $channelId, string $message)
    {
        $this->message = $message;
        $this->channelId = $channelId;
    }

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return "/messages";
    }

    protected function defaultBody(): array
    {
        return [
            'message' => $this->message,
            'channel_id' => $this->channelId,
        ];
    }
}
