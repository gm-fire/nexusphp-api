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

use Flarum\Api\Serializer\ForumSerializer;
use GmFire\NexusphpApi\Event\PostWasReply;
use GmFire\NexusphpApi\Notification\PostReplyBlueprint;
use Flarum\Api\Serializer\PostSerializer;
use Flarum\Extend;

return [

    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Routes('api'))
        ->patch('/nicknames/{username}', 'nicknames.update', Api\Controller\UpdateNicknameController::class)
        ->post('/seedbonus', 'seedbonus.create', Api\Controller\CreateSeedBonusController::class),

    (new Extend\Settings())
        ->default('gm-fire-nexusphp-api.apiurl', '')
        ->default('gm-fire-nexusphp-api.secret', ''),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attributes(Extenders\ForumAttributes::class),

    (new Extend\User())
        ->registerPreference('postAfterReply', 'boolval', true),

    (new Extend\Notification())
        ->type(PostReplyBlueprint::class, PostSerializer::class, ['push'])
        ->driver('push', PushNotificationDriver::class),

    (new Extend\Event())
        ->listen(PostWasReply::class, Listener\SendNotificationWhenPostIsReply::class)
        ->subscribe(Listener\SendPostReplyToPush::class),
];
