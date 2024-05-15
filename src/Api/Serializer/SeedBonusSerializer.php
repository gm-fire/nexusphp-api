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
use InvalidArgumentException;

class SeedBonusSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'seedbonus';

    /**
     * {@inheritdoc}
     */
    public function getId($model)
    {
        return '1';
    }

    /**
     * {@inheritdoc}
     *
     * @param SeedBonus $seedbonus
     * @throws InvalidArgumentException
     */
    protected function getDefaultAttributes($seedbonus)
    {
        // See https://docs.flarum.org/extend/api.html#serializers for more information.
        return $seedbonus;
    }
}
