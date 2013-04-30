<?php

namespace Acme\UserBundle\Domain\Event;

use Acme\CommonBundle\Domain\Event\DomainEvent;

class UserRegisteredEvent extends DomainEvent
{
    public $id;
    public $screenName;
    public $email;
    public $password;
    public $roles;
    public $enabled;
    public $createdAt;

    public function getEventName()
    {
        return 'UserRegistered';
    }
}