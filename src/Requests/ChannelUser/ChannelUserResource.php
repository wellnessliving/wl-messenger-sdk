<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\ChannelUser;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class ChannelUserResource extends BaseResource
{
    public function all(string $channelId): Response
    {
        return $this->connector->send(new GetChannelUsersRequest($channelId));
    }
}
