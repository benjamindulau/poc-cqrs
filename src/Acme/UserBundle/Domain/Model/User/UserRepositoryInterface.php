<?php

namespace Acme\UserBundle\Domain\Model\User;


interface UserRepositoryInterface
{
    /**
     * Finds an User using given Id
     *
     * @param mixed $id
     * @return User or null
     */
    function find($id);

    /**
     * Saves given User
     *
     * @param User $user
     * @return void
     */
    function save(User $user);
}