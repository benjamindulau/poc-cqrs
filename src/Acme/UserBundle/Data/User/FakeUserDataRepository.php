<?php

namespace Acme\UserBundle\Data\User;

use Symfony\Component\Security\Core\User\UserInterface;

class FakeUserDataRepository implements UserDataRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    /**
     * {@inheritDoc}
     */
    public function save(UserDto $user)
    {
        // TODO: Implement save() method.
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        // TODO: Implement loadUserByUsername() method.
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === 'Acme\\UserBundle\\Data\\User\\UserDto';
    }
}