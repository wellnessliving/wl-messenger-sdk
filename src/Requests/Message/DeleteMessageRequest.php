<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Message;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteMessageRequest extends Request
{
    protected Method $method = Method::DELETE;

    protected string $messageId;

    public function __construct(string $messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return '/messages/' . $this->messageId;
    }
}
