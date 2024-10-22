<?php

namespace Modules\User\Domain\Events;
use Modules\User\Domain\Aggregate\UserAggregate;

class StoreUserEvent
{
    public function __construct(public UserAggregate $userAggregate)
    {}
}
