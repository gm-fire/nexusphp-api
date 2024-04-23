<?php

namespace GmFire\NexusphpApi\Api\Controller;

use Flarum\Api\Controller\AbstractShowController;
use Flarum\Http\RequestUtil;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;
use GmFire\NexusphpApi\Command\EditNickname;
use GmFire\NexusphpApi\Api\Serializer\NicknameSerializer;

class UpdateNicknameController extends AbstractShowController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = NicknameSerializer::class;

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
        $modelId = Arr::get($request->getQueryParams(), 'username');
        $data = Arr::get($request->getParsedBody(), 'data', []);

        $model = $this->bus->dispatch(
            new EditNickname($modelId, $actor, $data)
        );

        return $model;
    }
}
