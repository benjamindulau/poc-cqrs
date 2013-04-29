<?php

namespace Acme\UserBundle\Data\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;

interface UserDataRepositoryInterface extends UserProviderInterface
{
    /**
     * @param mixed $id
     * @return UserDto
     */
    public function getById($id);

    /**
     * @param UserDto $user
     */
    public function save(UserDto $user);
}