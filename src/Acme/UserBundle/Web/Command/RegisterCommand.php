<?php

namespace Acme\UserBundle\Web\Command;

use LiteCQRS\DefaultCommand;

class RegisterCommand extends DefaultCommand
{
    public $screenName;
    public $email;
    public $password;
    public $roles = array();
}