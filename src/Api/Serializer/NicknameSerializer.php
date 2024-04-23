<?php

namespace GmFire\NexusphpApi\Api\Serializer;

use Flarum\Api\Serializer\AbstractSerializer;
use Flarum\User\User;
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
     * @param Nickname $user
     * @throws InvalidArgumentException
     */
    protected function getDefaultAttributes($user)
    {
        if (! ($user instanceof User)) {
            throw new InvalidArgumentException(
                get_class($this).' can only serialize instances of '.User::class
            );
        }


        // See https://docs.flarum.org/extend/api.html#serializers for more information.
        return [
            'username'           => $user->username,
            'displayName'        => $user->display_name,
            'avatarUrl'          => $user->avatar_url
        ];
    }
}
