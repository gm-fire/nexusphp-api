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
use Illuminate\Contracts\Events\Dispatcher;
use GuzzleHttp\Exception\ClientException;

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
        $actor = $command->actor;
        $data = $command->data;
        $response = [];

        try {
            $response = self::httpClient()->get('/api/flarum-medals/', ['json' => [
                "uid"  => $data['username']
            ]]);
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }

        if ($response) {
            $result = json_decode($response->getBody()->getContents(), true);
            return json_encode($result['data']);
        }

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
