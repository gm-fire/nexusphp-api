<?php

namespace GmFire\NexusphpApi\Command;

use Illuminate\Support\Arr;
use GmFire\NexusphpApi\NicknameRepository;
use GmFire\NexusphpApi\NicknameValidator;

class EditNicknameHandler
{
    /**
     * @var NicknameRepository
     */
    protected $repository;

    /**
     * @var NicknameValidator
     */
    protected $validator;

    public function __construct(NicknameRepository $repository, NicknameValidator $validator)
    {
        $this->repository = $repository;
		$this->validator = $validator;
    }

    public function handle(EditNickname $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $actor->assertCan('...');

        // ...

        return $model;
    }
}
