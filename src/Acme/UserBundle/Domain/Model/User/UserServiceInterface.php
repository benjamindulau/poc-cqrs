<?php

namespace Acme\UserBundle\Domain\Model\User;

use Acme\UserBundle\Web\Command\ChangeEmailCommand;
use Acme\UserBundle\Web\Command\RegisterCommand;
use Acme\UserBundle\Web\Command\VerifyEmailCommand;

interface UserServiceInterface
{
    function register(RegisterCommand $command);

    function changeEmail(ChangeEmailCommand $command);

    function verifyEmail(VerifyEmailCommand $command);
}