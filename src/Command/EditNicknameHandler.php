<?php

namespace GmFire\NexusphpApi\Command;

use Flarum\Foundation\DispatchEventsTrait;
use Flarum\User\Event\Saving;
use Flarum\User\UserRepository;
use Flarum\User\UserValidator;
use Illuminate\Contracts\Events\Dispatcher;

class EditNicknameHandler
{
    use DispatchEventsTrait;

    /**
     * @var \Flarum\User\UserRepository
     */
    protected $users;

    /**
     * @var UserValidator
     */
    protected $validator;

    /**
     * @param Dispatcher $events
     * @param \Flarum\User\UserRepository $users
     * @param UserValidator $validator
     */
    public function __construct(Dispatcher $events, UserRepository $users, UserValidator $validator)
    {
        $this->events = $events;
        $this->users = $users;
        $this->validator = $validator;
    }

    public function handle(EditNickname $command)
    {
        $username = $command->username;
        $actor = $command->actor;
        $data = $command->data;

        $user = $this->users->findOrFailByUsername($username);
        $validate = [];

        if (isset($data['nickname'])) {
            $nickname = $data['nickname'];
            $validate['nickname'] = $nickname;
            // If the user sets their nickname back to the username
            // set the nickname to null so that it just falls back to the username
            if ($user->username === $nickname) {
                $user->nickname = null;
            } else {
                $user->nickname = $nickname;
            }
        }

        $this->events->dispatch(
            new Saving($user, $actor, $data)
        );

        $this->validator->setUser($user);
        $this->validator->assertValid(array_merge($user->getDirty(), $validate));

        $user->save();

        $this->dispatchEventsFor($user, $actor);

        return $user;
    }
}
