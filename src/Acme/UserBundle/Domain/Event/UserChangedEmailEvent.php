<?php

namespace Acme\UserBundle\Domain\Event;

use Acme\CommonBundle\Domain\Event\DomainEvent;

class UserChangedEmailEvent extends DomainEvent
{
    public $id;
    public $email;
    public $emailVerified;

    public function getEventName()
    {
        return 'UserChangedEmail';
    }
}