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

use GmFire\NexusphpApi\Event\PostWasBonus;
use GmFire\NexusphpApi\Notification\PostBonusBlueprint;
use Flarum\Notification\NotificationSyncer;

class SendNotificationWhenPostIsBonus
{
    /**
     * @var NotificationSyncer
     */
    protected $notifications;

    /**
     * @param NotificationSyncer $notifications
     */
    public function __construct(NotificationSyncer $notifications)
    {
        $this->notifications = $notifications;
    }

    public function handle(PostWasBonus $event)
    {
        if ($event->post->user && $event->post->user->id != $event->user->id) {
            $this->notifications->sync(
                new PostBonusBlueprint($event->post, $event->user),
                [$event->post->user]
            );
        }
    }
}
