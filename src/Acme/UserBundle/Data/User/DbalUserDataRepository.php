<?php

namespace Acme\UserBundle\Data\User;

use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\User\UserInterface;

class DbalUserDataRepository implements UserDataRepositoryInterface
{
    private $connection;
    private $class = 'Acme\\UserBundle\\Data\\User\\UserDto';

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritDoc}
     */
    public function getById($id)
    {
        $row = $this->connection->fetchAssoc('SELECT * FROM users WHERE id = :id', array('id' => $id));
        if (!$row) {
            return null;
        }

        return $this->userRowToUserDto($row);
    }

    /**
     * {@inheritDoc}
     */
    public function getAll()
    {
        $rows = $this->connection->fetchAll('SELECT * FROM users');
        if (!$rows) {
            return null;
        }

        // TODO: move this responsability away, DTO/Assembler pattern or whatever
        $dtos = array();
        foreach($rows as $row) {
            $dtos[] = $this->userRowToUserDto($row);
        }

        return $dtos;
    }

    /**
     * {@inheritDoc}
     */
    public function saveOrUpdate(UserDto $user, $update = true)
    {
        $data = $this->userDtoToUserRow($user);

        if ($update) {
            $this->connection->update('users', $data, array('id' => $user->id));
        } else {
            $this->connection->insert('users', $data);
        }
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
        return $class === $this->class;
    }

    private function userRowToUserDto($row, UserDto $userDto = null)
    {
        // TODO: move this responsability away, maybe use hydrators + mapping files

        if (null == $userDto) {
            $userDto = new UserDto();
        }

        $userDto->id = $row['id'];
        $userDto->screenName = $row['screen_name'];
        $userDto->email = $row['email'];
        $userDto->emailVerified = $row['email_verified'];
        $userDto->password = $row['password'];
        $userDto->salt = $row['salt'];
        $userDto->enabled = $row['enabled'];
        $userDto->lastLoginAt = $this->connection->convertToPHPValue($row['last_login_at'], 'datetime');
        $userDto->createdAt = $this->connection->convertToPHPValue($row['created_at'], 'datetime');
        $userDto->roles = $this->connection->convertToPHPValue($row['roles'], 'array');

        return $userDto;
    }

    private function userDtoToUserRow(UserDto $userDto)
    {
        // TODO: move this responsability away, maybe use hydrators + mapping files
        $row = array(
            'id' => $userDto->id,
            'screen_name' => $userDto->screenName,
            'email' => $userDto->email,
            'email_verified' => $userDto->emailVerified,
            'password' => $userDto->password,
            'salt' => $userDto->salt,
            'enabled' => $userDto->enabled,
            'last_login_at' => $this->connection->convertToDatabaseValue($userDto->lastLoginAt, 'datetime'),
            'created_at' => $this->connection->convertToDatabaseValue($userDto->createdAt, 'datetime'),
            'roles' => $this->connection->convertToDatabaseValue($userDto->roles, 'array'),
        );

        return $row;
    }
}