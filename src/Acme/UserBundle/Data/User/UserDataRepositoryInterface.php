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
     * @return array|UserDto[]
     */
    public function getAll();

    /**
     * @param UserDto $user
     * @param bool    $update
     */
    public function saveOrUpdate(UserDto $user, $update = true);
}