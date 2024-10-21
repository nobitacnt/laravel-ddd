<?php

namespace Modules\User\Domain\Events;
use Modules\User\Domain\Entities\UserEntity;

class StoreUserEvent
{
    public function __construct(public UserEntity $userEntity)
    {}
}
