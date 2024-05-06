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
use Flarum\User\UserRepository;
use Flarum\User\UserValidator;
use GmFire\NexusphpApi\HttpClient;
use Illuminate\Contracts\Events\Dispatcher;

class CreateSeedBonusHandler
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

    public function handle(CreateSeedBonus $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $api = new HttpClient();
        $result = $api->getClient()->post('/api/flarum-seedbonus', ['json' => [
            "uid"  => $actor['username'],
            "data" => $data
        ]]);

        return json_encode($result->getBody()->getContents());
    }
}
