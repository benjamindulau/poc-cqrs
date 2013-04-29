<?php

namespace Acme\UserBundle\Web\Command;

use LiteCQRS\DefaultCommand;

class ChangeEmailCommand extends DefaultCommand
{
    public $id;
    public $email;
}