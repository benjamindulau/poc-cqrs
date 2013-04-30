<?php

namespace Acme\UserBundle\Persistence;

use Acme\UserBundle\Domain\Model\User\User;
use Acme\UserBundle\Domain\Model\User\UserRepositoryInterface;
use Doctrine\ORM\EntityManager;

class DoctrineUserRepository implements UserRepositoryInterface
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param string        $class         User model class
     */
    public function __construct(EntityManager $entityManager, $class)
    {
        $this->em = $entityManager;
        $this->class = $class;
    }

    /**
     * {@inheritDoc}
     */
    public function find($id)
    {
        return $this->em->getRepository($this->class)->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function save(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}