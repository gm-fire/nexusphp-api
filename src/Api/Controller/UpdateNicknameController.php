<?php

namespace GmFire\NexusphpApi\Api\Controller;

use Flarum\Api\Controller\AbstractShowController;
use Flarum\Http\RequestUtil;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;
use Nickname;

class UpdateNicknameController extends AbstractShowController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = Nickname::class;

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        // See https://docs.flarum.org/extend/api.html#api-endpoints for more information.

        $actor = RequestUtil::getActor($request);
        $modelId = Arr::get($request->getQueryParams(), 'username');
        $data = Arr::get($request->getParsedBody(), 'data', []);
        var_dump($modelId);
        var_dump(Arr::get($request->getParsedBody(), 'data'));
        // $model = ...
        die('123');
        return $model;
    }
}
