<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\NexusphpApi\Listener;

use Flarum\User\Event\AvatarChanged;
use GmFire\NexusphpApi\HttpClient;

class UserAvatarChanged
{

    public function handle(AvatarChanged $event)
    {
        $user = $event->user;
        $actor = $event->actor;

        $api = new HttpClient();
        $api->getClient()->post('/api/flarum-avatar', ['json' => [
            "uid"  => $actor['username'],
            "data" => [
                "avatar" => $user->avatar_url
            ]
        ]]);
    }
}
