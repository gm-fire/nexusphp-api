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

use Flarum\Api\Controller;
use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\User\Event\AvatarChanged;
use Flarum\Post\Filter\PostFilterer;
use Flarum\Post\Post;
use Flarum\User\Filter\UserFilterer;
use Flarum\User\User;
use GmFire\NexusphpApi\Query\BonusByFilter;
use GmFire\NexusphpApi\Api\LoadBonusRelationship;
use GmFire\NexusphpApi\Event\PostWasBonus;
use GmFire\NexusphpApi\Event\PostWasReply;
use GmFire\NexusphpApi\Notification\PostBonusBlueprint;
use GmFire\NexusphpApi\Notification\PostReplyBlueprint;
use Flarum\Api\Serializer\PostSerializer;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\Frontend\Document;
use Flarum\Extend;

return [

    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less')
        ->content(function (Document $document) {
            $settings = resolve(SettingsRepositoryInterface::class);

            // 将设置注入前端全局变量
            $document->payload['nexusphpApiPluginSettings'] = [
                'apiurl' => $settings->get('gm-fire-nexusphp-api.apiurl')
            ];
        }),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Model(Post::class))
        ->belongsToMany('bonus', User::class, 'post_bonus', 'post_id', 'user_id'),

    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Routes('api'))
        ->get('/medals', 'medals.index', Api\Controller\ListMedalsController::class)
        ->patch('/nicknames/{username}', 'nicknames.update', Api\Controller\UpdateNicknameController::class)
        ->post('/seedbonus', 'seedbonus.create', Api\Controller\CreateSeedBonusController::class)
        ->post('/avatarupload', 'avatar.upload', Api\Controller\UploadAvatarController::class),

    (new Extend\Settings())
        ->default('gm-fire-nexusphp-api.apiurl', '')
        ->default('gm-fire-nexusphp-api.secret', ''),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attributes(Extenders\ForumAttributes::class),

    (new Extend\ApiSerializer(PostSerializer::class))
        ->hasMany('bonus', BasicUserSerializer::class)
        ->attribute('bonusCount', function (PostSerializer $serializer, $model) {
            return $model->getAttribute('bonus_count') ?: 0;
        }),

    (new Extend\ApiController(Controller\ShowDiscussionController::class))
        ->addInclude('posts.bonus')
        ->loadWhere('posts.bonus', [LoadBonusRelationship::class, 'mutateRelation'])
        ->prepareDataForSerialization([LoadBonusRelationship::class, 'countRelation']),

    (new Extend\User())
        ->registerPreference('postAfterReply', 'boolval', true),

    (new Extend\Notification())
        ->type(PostBonusBlueprint::class, PostSerializer::class, ['alert'])
        ->type(PostReplyBlueprint::class, PostSerializer::class, ['push'])
        ->driver('push', PushNotificationDriver::class),

    (new Extend\Filter(PostFilterer::class))
        ->addFilter(BonusByFilter::class),

    (new Extend\Event())
        ->listen(AvatarChanged::class, Listener\UserAvatarChanged::class)
        ->listen(PostWasBonus::class, Listener\SendNotificationWhenPostIsBonus::class)
        ->listen(PostWasReply::class, Listener\SendNotificationWhenPostIsReply::class)
        ->subscribe(Listener\SendPostReplyToPush::class),

    (new Extend\Policy())
        ->modelPolicy(Post::class, Access\BonusPostPolicy::class),
];
