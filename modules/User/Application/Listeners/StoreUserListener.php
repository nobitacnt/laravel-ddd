<?php

namespace Modules\User\Application\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\User\Domain\Entities\UserEntity;
use Modules\User\Domain\Events\StoreUserEvent;

class StoreUserListener
{
    public function handle(StoreUserEvent $event): void
    {
        $userEntity = $event->userEntity;
        $this->logStoreUser($userEntity);
    }

    public function logStoreUser(UserEntity $userEntity) {
        Log::info('storeUser '.$userEntity->name);
    }
}
