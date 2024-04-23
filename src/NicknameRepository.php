<?php

namespace GmFire\NexusphpApi;

use Flarum\User\User;
use Illuminate\Database\Eloquent\Builder;
use GmFire\NexusphpApi\Nickname;

class NicknameRepository
{
    /**
     * @return Builder
     */
    public function query()
    {
        return Nickname::query();
    }

    /**
     * @param int $id
     * @param User $actor
     * @return Nickname
     */
    public function findOrFail($id, User $actor = null): Nickname
    {
        return Nickname::findOrFail($id);
    }
}
