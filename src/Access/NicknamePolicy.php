<?php

namespace GmFire\NexusphpApi\Access;

use GmFire\NexusphpApi\Nickname;
use Flarum\User\Access\AbstractPolicy;
use Flarum\User\User;

class NicknamePolicy extends AbstractPolicy
{
    public function can(User $actor, string $ability, Nickname $model)
    {
        // See https://docs.flarum.org/extend/authorization.html#custom-policies for more information.
    }
}
