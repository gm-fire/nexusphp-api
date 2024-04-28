<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\NexusphpApi\Command;

use Flarum\User\User;

class EditNickname
{
    /**
     * @var int
     */
    public $username;

    /**
     * @var \Flarum\User\User
     */
    public $actor;

    /**
     * @var array
     */
    public $data;

    public function __construct($username, User $actor, array $data)
    {
        $this->username = $username;
        $this->actor = $actor;
        $this->data = $data;
    }
}
