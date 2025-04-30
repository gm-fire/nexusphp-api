<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\NexusphpApi\Command;

use Flarum\Foundation\DispatchEventsTrait;
use Flarum\Post\CommentPost;
use Flarum\Post\PostRepository;
use Flarum\User\UserRepository;
use Flarum\User\UserValidator;
use GmFire\NexusphpApi\HttpClient;
use GmFire\NexusphpApi\Event\PostWasBonus;
use Illuminate\Contracts\Events\Dispatcher;
use Tobscure\JsonApi\Exception\InvalidParameterException;

class CreateSeedBonusHandler
{
    use DispatchEventsTrait;

    /**
     * @var PostRepository
     */
    protected $posts;

    /**
     * @var \Flarum\User\UserRepository
     */
    protected $users;

    /**
     * @var UserValidator
     */
    protected $validator;

    /**
     * @param PostRepository $posts
     * @param Dispatcher $events
     * @param \Flarum\User\UserRepository $users
     * @param UserValidator $validator
     */
    public function __construct(PostRepository $posts, Dispatcher $events, UserRepository $users, UserValidator $validator)
    {
        $this->posts = $posts;
        $this->events = $events;
        $this->users = $users;
        $this->validator = $validator;
    }

    public function handle(CreateSeedBonus $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $api = new HttpClient();
        $result = $api->getClient()->post('/api/flarum-seedbonus', ['json' => [
            "uid"  => $actor['username'],
            "data" => $data
        ]]);

        $seedBonus = json_decode($result->getBody()->getContents(), true);
        if ($seedBonus['ret'] == '0') {
            $post = $this->posts->findOrFail($data['postId'], $actor);
            if (! ($post instanceof CommentPost)) {
                throw new InvalidParameterException;
            }
            if ($actor->id != $post->user->id) {
                $post->bonus()->attach($actor->id);
                $this->events->dispatch(new PostWasBonus($post, $actor));
            }
        }

        return $seedBonus;
    }
}
