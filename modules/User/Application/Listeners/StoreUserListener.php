<?php

namespace Modules\User\Application\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\User\Domain\Aggregate\UserAggregate;
use Modules\User\Domain\Entities\UserEntity;
use Modules\User\Domain\Events\StoreUserEvent;

class StoreUserListener
{
    public function handle(StoreUserEvent $event): void
    {
        $userAggregate = $event->userAggregate;
        $this->logStoreUser($userAggregate);
    }

    public function logStoreUser(UserAggregate $userAggregate): void
    {
        Log::info('storeUser '.$userAggregate->getRoot()->name);
    }
}
