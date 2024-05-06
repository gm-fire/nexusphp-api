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

use Flarum\Settings\SettingsRepositoryInterface;

class HttpClient
{
    protected $client;

    public function __construct()
    {
        $settings = app(SettingsRepositoryInterface::class);
        $apiurl = $settings->get('gm-fire-nexusphp-api.apiurl');
        $secret = $settings->get('gm-fire-nexusphp-api.secret');
        $headers = [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
            'Authorization' => $secret
        ];

        $this->client = new \GuzzleHttp\Client(['base_uri' => $apiurl, 'headers' => $headers]);
    }

    public function getClient(): \GuzzleHttp\Client
    {
        return $this->client;
    }
}
