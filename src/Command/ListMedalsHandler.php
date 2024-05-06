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
use GmFire\NexusphpApi\HttpClient;
use Illuminate\Contracts\Events\Dispatcher;

class ListMedalsHandler
{
    use DispatchEventsTrait;

    /**
     * @var \Flarum\User\UserRepository
     */
    protected $users;

    /**
     * @param Dispatcher $events
     * @param \Flarum\User\UserRepository $users
     */
    public function __construct(Dispatcher $events, UserRepository $users)
    {
        $this->events = $events;
        $this->users = $users;
    }

    public function handle(ListMedals $command)
    {
        $data = $command->data;

        $api = new HttpClient();
        $response = $api->getClient()->get('/api/flarum-medals/', ['json' => [
            "uid"  => $data['username']
        ]]);

        if ($response) {
            $result = json_decode($response->getBody()->getContents(), true);
            return json_encode($result['data']);
        }
    }
}
