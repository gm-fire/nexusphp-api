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
use Flarum\User\AvatarUploader;
use Flarum\User\AvatarValidator;
use Flarum\User\Event\AvatarSaving;
use Flarum\User\UserRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Validation\Factory;
use Intervention\Image\ImageManager;
use Intervention\Image\Exception\NotReadableException;
use InvalidArgumentException;

class UploadAvatarHandler
{
    use DispatchEventsTrait;

    /**
     * @var \Flarum\User\UserRepository
     */
    protected $users;

    /**
     * @var AvatarUploader
     */
    protected $uploader;

    /**
     * @var Factory
     */
    private $validator;

    /**
     * @var ImageManager
     */
    protected $imageManager;

    /**
     * @param Dispatcher $events
     * @param UserRepository $users
     * @param AvatarUploader $uploader
     * @param AvatarValidator $validator
     */
    public function __construct(Dispatcher $events, UserRepository $users, AvatarUploader $uploader, Factory $validator, ImageManager $imageManager)
    {
        $this->events = $events;
        $this->users = $users;
        $this->uploader = $uploader;
        $this->validator = $validator;
        $this->imageManager = $imageManager;
    }

    /**
     * @param UploadAvatar $command
     * @return \Flarum\User\User
     * @throws \Flarum\User\Exception\PermissionDeniedException
     * @throws \Flarum\Foundation\ValidationException
     * @throws NotReadableException
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

        try {
            $image = $this->imageManager->make($url);
        } catch (NotReadableException $e) {
            return $e->getMessage();
        }

        $this->events->dispatch(
            new AvatarSaving($user, $actor, $image)
        );

        $this->uploader->upload($user, $image);

        $user->save();

        $this->dispatchEventsFor($user, $actor);

        return $user;
    }
}
