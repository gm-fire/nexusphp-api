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

class UploadAvatar
{
    /**
     * The ID of the user to upload the avatar for.
     *
     * @var int
     */
    public $userId;

    /**
     * The avatar file to upload.
     *
     * @var url
     */
    public $file;

    /**
     * The user performing the action.
     *
     * @var User
     */
    public $actor;

    /**
     * @param int $userId The ID of the user to upload the avatar for.
     * @param url $file The avatar file to upload.
     * @param User $actor The user performing the action.
     */
    public function __construct($userId, $file, User $actor)
    {
        $this->userId = $userId;
        $this->file = $file;
        $this->actor = $actor;
    }
}
