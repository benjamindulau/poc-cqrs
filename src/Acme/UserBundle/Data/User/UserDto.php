<?php

namespace Acme\UserBundle\Data\User;

use Symfony\Component\Security\Core\User\UserInterface;

class UserDto implements UserInterface
{
    public $id;
    public $defaultRole = 'ROLE_USER';
    public $screenName;
    public $email;
    public $emailVerified;
    public $password;
    public $salt;
    public $enabled;
    public $lastLoginAt;
    public $createdAt;
    public $roles;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getUsername();
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->screenName;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // read model, nothing to do
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;
        // we need to make sure to have at least one role
        $roles[] = $this->defaultRole;

        return array_unique($roles);
    }
}