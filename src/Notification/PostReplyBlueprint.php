<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\NexusphpApi\Notification;

use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\Post\Post;
use Flarum\User\User;

class PostReplyBlueprint implements BlueprintInterface
{
    /**
     * @var Post
     */
    public $post;

    /**
     * @var User
     */
    public $user;

    /**
     * @param Post $post
     * @param User $user
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->post;
    }

    /**
     * {@inheritdoc}
     */
    public function getFromUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function getType()
    {
        return 'postReply';
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubjectModel()
    {
        return Post::class;
    }
}
