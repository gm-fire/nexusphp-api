<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\NexusphpApi\Api\Controller;

use Flarum\Api\Controller\AbstractShowController;
use Flarum\Api\Serializer\UserSerializer;
use Flarum\Http\RequestUtil;
use Illuminate\Contracts\Bus\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;
use GmFire\NexusphpApi\Command\ListMedals;

class ListMedalsController extends AbstractShowController
{

    /**
     * {@inheritdoc}
     */
    public $serializer = UserSerializer::class;

    /**
     * @var Dispatcher
     */
    protected $bus;

    /**
     * @param Dispatcher $bus
     */
    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }


    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        // See https://docs.flarum.org/extend/api.html#api-endpoints for more information.
        $actor = RequestUtil::getActor($request);
        $data = $request->getQueryParams();

        return $this->bus->dispatch(
            new ListMedals($actor, $data)
        );
    }
}
