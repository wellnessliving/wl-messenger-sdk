<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Message;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasFormBody;

class UpdateMessageRequest extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::PATCH;

    protected string $messageId;

    protected string $message;

    public function __construct(string $messageId, string $message)
    {
        $this->messageId = $messageId;
        $this->message = $message;
    }

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return '/messages/' . $this->messageId;
    }

    protected function defaultBody(): array
    {
        return [
            'message' => $this->message,
        ];
    }
}
