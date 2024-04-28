<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\NexusphpApi\Job;

use Flarum\User\User;
use GmFire\NexusphpApi\PushSender;
use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\Queue\AbstractJob;

class SendPushNotificationsJob extends AbstractJob
{
    /**
     * @var BlueprintInterface
     */
    private $blueprint;

    /**
     * @var User[]
     */
    private $recipients;

    public function __construct(BlueprintInterface $blueprint, array $recipients = [])
    {
        $this->blueprint = $blueprint;
        $this->recipients = $recipients;
    }

    public function handle()
    {
        PushSender::notify($this->recipients, $this->blueprint);
    }
}
