<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\NexusphpApi\Api;

use Flarum\Discussion\Discussion;
use Flarum\Http\RequestUtil;
use Flarum\Post\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Expression;
use Psr\Http\Message\ServerRequestInterface;

class LoadBonusRelationship
{
    public static $maxBonus = 4;

    public static function mutateRelation(BelongsToMany $query, ServerRequestInterface $request): BelongsToMany
    {
        $actor = RequestUtil::getActor($request);

        $grammar = $query->getQuery()->getGrammar();

        return $query
            ->orderBy(new Expression($grammar->wrap('user_id').' = '.$actor->id), 'desc')
            ->distinct()
            ->limit(self::$maxBonus);
    }

    /**
     * Called using the @see ApiController::prepareDataForSerialization extender.
     */
    public static function countRelation($controller, $data): void
    {
        $loadable = null;

        if ($data instanceof Discussion) {
            $loadable = $data->newCollection($data->posts)->filter(function ($post) {
                return $post instanceof Post;
            });
        } elseif ($data instanceof Collection) {
            $loadable = $data;
        } elseif ($data instanceof Post) {
            $loadable = $data->newCollection([$data]);
        }

        if ($loadable) {
            $loadable->loadCount('bonus');
        }
    }
}
