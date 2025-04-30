<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\NexusphpApi\Access;

use Flarum\Post\Post;
use Flarum\User\Access\AbstractPolicy;
use Flarum\User\User;

class BonusPostPolicy extends AbstractPolicy
{
    public function bonus(User $actor, Post $post)
    {
        if ($actor->id === $post->user_id) {
            return $this->deny();
        }
    }
}
