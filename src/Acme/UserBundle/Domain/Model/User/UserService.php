<?php

namespace Acme\UserBundle\Domain\Model\User;

use Acme\UserBundle\Web\Command\ChangeEmailCommand;
use Acme\UserBundle\Web\Command\RegisterCommand;
use Acme\UserBundle\Web\Command\VerifyEmailCommand;
use LiteCQRS\Bus\IdentityMap\SimpleIdentityMap;

class UserService implements UserServiceInterface
{
    protected $identityMap;
    protected $userRepository;

    public function __construct(SimpleIdentityMap $identityMap, UserRepositoryInterface $userRepository)
    {
        $this->identityMap = $identityMap;
        $this->userRepository = $userRepository;
    }

    public function register(RegisterCommand $command)
    {
        // TODO: validate command again (really the right place for doing it?)

        // TODO: Implement a factory example
        $user = new User();
        $this->identityMap->add($user);

        // TODO: add business rules validation in User object
        $user->register(
            $command->screenName,
            $command->email,
            $command->password,
            $command->roles
        );

        $this->userRepository->save($user);
    }

    public function changeEmail(ChangeEmailCommand $command)
    {
        // TODO: same todos as in "register" command

        if (! ($user = $this->userRepository->find($command->id))) {
            // TODO: throw exception ?
        }

        $user->changeEmail($command->email);

        $this->userRepository->save($user);
    }

    public function verifyEmail(VerifyEmailCommand $command)
    {
        // TODO: same todos as in "register" command

        if (! ($user = $this->userRepository->find($command->id))) {
            // TODO: throw exception ?
        }

        $user->verifyEmail($command->email);

        $this->userRepository->save($user);
    }
}