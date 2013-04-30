<?php

namespace Acme\UserBundle\Data\User;

use Acme\UserBundle\Domain\Event\UserChangedEmailEvent;
use Acme\UserBundle\Domain\Event\UserRegisteredEvent;
use Acme\UserBundle\Domain\Event\UserVerifiedEmailEvent;

class UserEventHandler
{
    private $userDataRepository;

    public function __construct(UserDataRepositoryInterface $userDataRepository)
    {
        $this->userDataRepository = $userDataRepository;
    }

    public function onUserRegistered(UserRegisteredEvent $event)
    {
        $userDto = new UserDto();

        // TODO: automatize DTO assemblage, maybe by using event introspection?
        $userDto->id = $event->id;
        $userDto->screenName = $event->screenName;
        $userDto->email = $event->email;
        $userDto->emailVerified = false;
        $userDto->password = $event->password;
        $userDto->roles = $event->roles;
        $userDto->enabled = $event->enabled;
        $userDto->createdAt = $event->createdAt;

        $this->userDataRepository->saveOrUpdate($userDto, false);
    }

    public function onUserChangedEmail(UserChangedEmailEvent $event)
    {
        $userDto = $this->userDataRepository->getById($event->id);
        if (null == $userDto) {
            // TODO: do something? Is the test relevant?
        }

        $userDto->email = $event->email;
        $userDto->emailVerified = $event->emailVerified;

        $this->userDataRepository->saveOrUpdate($userDto, true);
    }

    public function onUserVerifiedEmail(UserVerifiedEmailEvent $event)
    {
        $userDto = $this->userDataRepository->getById($event->id);
        if (null == $userDto) {
            // TODO: do something? Is the test relevant?
        }

        $userDto->emailVerified = true;

        $this->userDataRepository->saveOrUpdate($userDto, true);
    }
}