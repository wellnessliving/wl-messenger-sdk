<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk\Requests\Channel;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class ChannelResource extends BaseResource
{
    public function all(): Response
    {
        return $this->connector->send(new GetChannelsRequest());
    }

    public function get(string|int $id): Response
    {
        return $this->connector->send(new GetChannelRequest($id));
    }

    public function getByTopicId(string $topicId): Response
    {
        $request = new GetChannelsRequest();
        $request->query()->add('topic_id', $topicId);

        return $this->connector->send($request);
    }

    public function create(
        string $topicId,
        string $topic,
        ?string $description = null,
        bool $isPrivate = false,
        array $metaData = []
    ): Response {

        $payload = [
            'topic_id' => $topicId,
            'topic' => $topic,
            'is_private' => $isPrivate,
            'description' => $description,
            'meta_data' => $metaData,
        ];

        $request = new CreateChannelRequest($payload);

        // Most default values
        $request->body()
            ->add('topic_id', $topicId)
            ->add('topic', $topic)
            ->add('is_private', $isPrivate)
            ->add('meta_data', $metaData);

        /**
         * Description is nullable, so unless
         * we set something, then lets guess
         * that we dont need to do anything
         */
        if (is_string($description)) {
            $request->body()->add('description', $description);
        }

        return $this->connector->send($request);
    }

    public function update(
        string|int $channelId,
        ?string $topic = null,
        ?string $description = null,
        ?bool $isPrivate = null,
        ?array $metaData = null
    ): Response {

        $request = new UpdateChannelRequest($channelId);

        if (is_string($topic)) {
            $request->body()->add('topic', $topic);
        }

        if (is_string($description)) {
            $request->body()->add('description', $description);
        }

        if (is_string($isPrivate)) {
            $request->body()->add('is_private', $isPrivate);
        }

        if (is_array($metaData)) {
            $request->body()->add('meta_data', $metaData);
        }

        return $this->connector->send($request);
    }

    public function delete(string|int $id): Response
    {
        return $this->connector->send(new DeleteChannelRequest($id));
    }
}
