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
use Flarum\User\AvatarValidator;
use Flarum\User\UserRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Validation\Factory;

class UploadAvatarHandler
{
    use DispatchEventsTrait;

    /**
     * @var \Flarum\User\UserRepository
     */
    protected $users;

    /**
     * @var Factory
     */
    private $validator;

    /**
     * @param Dispatcher $events
     * @param UserRepository $users
     * @param AvatarValidator $validator
     */
    public function __construct(Dispatcher $events, UserRepository $users, Factory $validator)
    {
        $this->events = $events;
        $this->users = $users;
        $this->validator = $validator;
    }

    /**
     * @param UploadAvatar $command
     * @return \Flarum\User\User
     */
    public function handle(UploadAvatar $command)
    {
        $actor = $command->actor;
        $url = $command->file;

        $user = $this->users->findOrFail($command->userId);

        $actor->assertCan('uploadAvatar', $user);

        $urlValidator = $this->validator->make(compact('url'), [
            'url' => 'required|active_url',
        ]);

        if ($urlValidator->fails()) {
            return 'Provided avatar URL must be a valid URI.';
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);

        if (! in_array($scheme, ['http', 'https'])) {
            return "Provided avatar URL must have scheme http or https. Scheme provided was $scheme.";
        }

        $user->avatar_url = $url;
        $user->save();

        $this->dispatchEventsFor($user, $actor);

        return $user;
    }
}
