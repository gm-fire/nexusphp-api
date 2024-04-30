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

use GmFire\NexusphpApi\Event\PostWasReply;
use GmFire\NexusphpApi\Notification\PostReplyBlueprint;
use Flarum\Api\Serializer\PostSerializer;
use Flarum\Extend;

return [

    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Routes('api'))
        ->patch('/nicknames/{username}', 'nicknames.update', Api\Controller\UpdateNicknameController::class),

    (new Extend\Settings())
        ->default('nexusphp-api.apiurl', '')
        ->default('nexusphp-api.secret', ''),

    (new Extend\User())
        ->registerPreference('postAfterReply', 'boolval', true),

    (new Extend\Notification())
        ->type(PostReplyBlueprint::class, PostSerializer::class, ['push'])
        ->driver('push', PushNotificationDriver::class),

    (new Extend\Event())
        ->listen(PostWasReply::class, Listener\SendNotificationWhenPostIsReply::class)
        ->subscribe(Listener\SendPostReplyToPush::class),
];
