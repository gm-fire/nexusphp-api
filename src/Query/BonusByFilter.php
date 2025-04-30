<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\NexusphpApi\Query;

use Flarum\Filter\FilterInterface;
use Flarum\Filter\FilterState;
use Flarum\Filter\ValidateFilterTrait;

class BonusByFilter implements FilterInterface
{
    use ValidateFilterTrait;

    public function getFilterKey(): string
    {
        return 'bonusBy';
    }

    public function filter(FilterState $filterState, $filterValue, bool $negate)
    {
        $bonusId = $this->asInt($filterValue);

        $filterState
            ->getQuery()
            ->whereIn('id', function ($query) use ($bonusId, $negate) {
                $query->select('post_id')
                    ->from('post_bonus')
                    ->where('user_id', $negate ? '!=' : '=', $bonusId);
            });
    }
}
