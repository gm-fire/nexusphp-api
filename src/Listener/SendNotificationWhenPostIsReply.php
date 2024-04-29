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

use Flarum\Discussion\Discussion;
use GmFire\NexusphpApi\Event\PostWasReply;
use GmFire\NexusphpApi\Notification\PostReplyBlueprint;
use Flarum\Notification\NotificationSyncer;

class SendNotificationWhenPostIsReply
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

    public function handle(PostWasReply $event)
    {
        $discussion = Discussion::find($event->post['discussion_id']);
        if ($event->post->user && $event->post->user->id != $discussion->user->id) {
            $this->notifications->sync(
                new PostReplyBlueprint($event->post, $event->user),
                [$discussion->user]
            );
        }
    }
}
