<?php

namespace GmFire\NexusphpApi\Command;

use Flarum\User\User;

class EditNickname
{
    /**
     * @var int
     */
    public $username;

    /**
     * @var \Flarum\User\User
     */
    public $actor;

    /**
     * @var array
     */
    public $data;

    public function __construct($username, User $actor, array $data)
    {
        $this->username = $username;
        $this->actor = $actor;
        $this->data = $data;
    }
}
