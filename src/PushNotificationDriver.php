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

use Flarum\Notification\Driver\NotificationDriverInterface;
use GmFire\NexusphpApi\Job\SendPushNotificationsJob;
use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\User\User;
use Illuminate\Contracts\Queue\Queue;

class PushNotificationDriver implements NotificationDriverInterface
{
    private $queue;

    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    public function registerType(string $blueprintClass, array $driversEnabledByDefault): void
    {
        User::registerPreference(
            User::getNotificationPreferenceKey($blueprintClass::getType(), 'push'),
            'boolval',
            in_array('push', $driversEnabledByDefault)
        );
    }

    public function send(BlueprintInterface $blueprint, array $users): void
    {
//        var_dump($blueprint->getSubject());
//        var_dump($blueprint->getFromUser());
        var_dump($blueprint->getType());
        if (count($users)) {
            $this->queue->push(new SendPushNotificationsJob($blueprint, $users));
        }
    }

}
