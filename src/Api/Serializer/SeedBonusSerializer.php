<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\NexusphpApi\Api\Serializer;

use Flarum\Api\Serializer\AbstractSerializer;
use Flarum\User\User;
use InvalidArgumentException;

class SeedBonusSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'seedbonus';

    /**
     * {@inheritdoc}
     *
     * @param SeedBonus $user
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
        return [];
    }
}
