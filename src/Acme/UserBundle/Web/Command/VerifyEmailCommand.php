<?php

namespace Acme\UserBundle\Web\Command;

use LiteCQRS\DefaultCommand;

class VerifyEmailCommand extends DefaultCommand
{
    public $id;
    public $email;
}