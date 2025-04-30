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

use Flarum\Notification\Blueprint\BlueprintInterface;
use Illuminate\Support\Arr;
use Symfony\Contracts\Translation\TranslatorInterface;
use Flarum\Post\CommentPost;
use Flarum\Post\Post;
use Flarum\Discussion\Discussion;
use Flarum\Http\UrlGenerator;

class PushSender
{

    public static function notify(array $recipients, BlueprintInterface $blueprint)
    {
        $subject = self::getTitle($blueprint);
        $content = self::getUrl($blueprint);
        $userIds = Arr::pluck($recipients, 'username');

        // 请求nuxesphp api发短消息
        $api = new HttpClient();
        $api->getClient()->post('/api/flarum-messages', ['json' => [
            "uid"  => $userIds[0],
            "data" => [
                "subject" => $subject,
                "body" => htmlspecialchars($content)
            ]
        ]]);
    }

    protected static function getTitle(BlueprintInterface $blueprint)
    {
        if ($blueprint->getType() == 'postReply' || $blueprint->getType() == 'postMentioned') {
            $translator = app(TranslatorInterface::class);

            return $translator->trans(
                'gm-fire-nexusphp-api.forum.notifications.post_reply_text',
                ['username' => $blueprint->getFromUser()->getDisplayNameAttribute()]
            );
        }
    }

    protected static function getBody(BlueprintInterface $blueprint)
    {
        $content = '';

        $subject = $blueprint->getSubject();

        switch ($blueprint::getSubjectModel()) {
            case Discussion::class:
                /** @var Discussion $subject */
                $content = self::getRelevantPostContent($subject);
                break;
            case Post::class:
                /** @var Post $subject */
                if ($subject instanceof CommentPost) {
                    $content = $subject->formatContent();
                }
                break;
        }

        return $content;
    }

    protected static function getUrl(BlueprintInterface $blueprint): string
    {
        $url = app(UrlGenerator::class);
        $subject = $blueprint->getSubject();

        switch ($blueprint::getSubjectModel()) {
            case User::class:
                /** @var User $subject */
                return $url->to('forum')->route('user', ['username' => $subject->display_name]);

            case Discussion::class:
                /** @var Discussion $subject */
                return $url->to('forum')->route('discussion', ['id' => $subject->id]);

            case Post::class:
                /** @var Post $subject */
                return $url->to('forum')->route(
                    'discussion',
                    ['id' => $subject->discussion_id, 'near' => $subject->number]
                );

            default:
                return $url->to('forum')->base();
        }
    }

    protected static function getRelevantPostContent($discussion): string
    {
        $relevantPost = $discussion->mostRelevantPost ?: $discussion->firstPost ?: $discussion->comments->first();

        if ($relevantPost === null) {
            return '';
        }

        return $relevantPost->formatContent();
    }

}
