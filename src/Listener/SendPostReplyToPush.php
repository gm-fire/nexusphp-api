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

use GmFire\NexusphpApi\Event\PostWasReply;
use Flarum\Post\Event\Saving;
use Illuminate\Contracts\Events\Dispatcher;

class SendPostReplyToPush
{
    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Saving::class, [$this, 'whenPostReplyIsSaving']);
    }

    /**
     * @param Saving $event
     */
    public function whenPostReplyIsSaving(Saving $event)
    {
        $post = $event->post;
        $actor = $event->actor;

        if ($post && $actor) {
            if ($post->discussion->user->id !== $actor->id) {
                $post->raise(new PostWasReply($post, $actor));
            }
        }
    }

}
