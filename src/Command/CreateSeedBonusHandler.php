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
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\UserRepository;
use Flarum\User\UserValidator;
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

        self::httpClient()->post('/api/flarum-seedbonus', ['json' => [
            "uid"  => $actor['username'],
            "data" => $data
        ]]);
    }

    protected function httpClient()
    {
        $settings = app(SettingsRepositoryInterface::class);
        $apiurl = $settings->get('nexusphp-api.apiurl');
        $secret = $settings->get('nexusphp-api.secret');
        $headers = [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
            'Authorization' => $secret
        ];
        return new \GuzzleHttp\Client(['base_uri' => $apiurl, 'headers' => $headers]);
    }
}
