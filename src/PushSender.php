<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\NexusphpApi;

use Carbon\Carbon;
use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class PushSender
{

    public static function notify(array $recipients, BlueprintInterface $blueprint)
    {
        $userIds = Arr::pluck($recipients, 'username');
        var_dump($userIds);
        die('123');
    }

}
