<?php

namespace GmFire\NexusphpApi\Api\Serializer;

use Flarum\Api\Serializer\AbstractSerializer;
use GmFire\NexusphpApi\Nickname;
use InvalidArgumentException;

class NicknameSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'nicknames';

    /**
     * {@inheritdoc}
     *
     * @param Nickname $model
     * @throws InvalidArgumentException
     */
    protected function getDefaultAttributes($model)
    {
        if (! ($model instanceof Nickname)) {
            throw new InvalidArgumentException(
                get_class($this).' can only serialize instances of '.Nickname::class
            );
        }

        // See https://docs.flarum.org/extend/api.html#serializers for more information.

        return [
            // ...
        ];
    }
}
