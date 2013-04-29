<?php

namespace Acme\UserBundle\Domain\Event;

use Acme\CommonBundle\Domain\Event\DomainEvent;

class UserVerifiedEmailEvent extends DomainEvent
{
    public $id;
    public $email;

    public function getEventName()
    {
        return 'UserVerifiedEmail';
    }
}