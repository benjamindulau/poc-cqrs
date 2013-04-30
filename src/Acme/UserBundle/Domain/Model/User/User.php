<?php

namespace Acme\UserBundle\Domain\Model\User;

use Acme\CommonBundle\Domain\Event\DomainEventProvider;
use Acme\UserBundle\Domain\Event\UserChangedEmailEvent;
use Acme\UserBundle\Domain\Event\UserRegisteredEvent;
use Acme\UserBundle\Domain\Event\UserVerifiedEmailEvent;
use Ano\Utils\Guid;
use DateTime;

class User extends DomainEventProvider
{
    const ROLE_DEFAULT = 'ROLE_USER';

    protected $id;
    protected $screenName;
    protected $email;
    protected $emailVerified;
    protected $emailVerificationToken;
    protected $emailVerifiedAt;
    protected $password;
    protected $salt;
    protected $algorithm;
    protected $enabled;
    protected $roles;
    protected $createdAt;
    protected $lastLoginAt;

    /**
     * Registers a new user account
     *
     * @param string $screenName
     * @param string $email
     * @param string $password
     * @param array  $roles
     */
    public function register($screenName, $email, $password, array $roles = array())
    {
        // TODO: make the ID a Value Object
        $guid = new Guid();
        $this->id = $guid->generateGuid();

        $this->createdAt = new DateTime();
        $this->screenName = $screenName;
        $this->email = $email;

        // TODO: implement password encoding;
        $this->password = $password;

        $this->roles = $roles;
        if (empty($this->roles)) {
            $this->roles = array(self::ROLE_DEFAULT);
        }

        // TODO: maybe activationToken should be a Token Value Object ?
        $this->emailVerificationToken = $this->generateToken();
        $this->emailVerified = false;

        // Users don't have to wait for starting using the website
        // They should verify their email though for using some features
        $this->enabled = true;

        $this->raise(new UserRegisteredEvent(array(
            'id' => $this->id,
            'screenName' => $this->screenName,
            'email' => $this->email,
            'password' => $this->password,
            'roles' => $this->roles,
            'enabled' => $this->enabled,
            'createdAt' => $this->createdAt,
        )));
    }

    /**
     * Called when a user email has been verified
     */
    public function verifyEmail()
    {
        $this->emailVerificationToken = null;
        $this->emailVerifiedAt = new DateTime();

        $this->raise(new UserVerifiedEmailEvent(array(
            'id' => $this->id,
            'email' => $this->email,
        )));
    }

    /**
     * Updates user email address
     *
     * @param string $email
     * @param bool   $needEmailVerification
     */
    public function changeEmail($email, $needEmailVerification = true)
    {
        $this->email = $email;
        if ($needEmailVerification) {
            $this->emailVerified = false;
            $this->emailVerifiedAt = null;
            $this->emailVerificationToken = $this->generateToken();
        }

        $this->raise(new UserChangedEmailEvent(array(
            'id' => $this->id,
            'email' => $this->email,
            'emailVerified' => $this->emailVerified,
        )));
    }

    /**
     * @return bool
     */
    public function isEmailVerified()
    {
        return $this->emailVerified;
    }

    /**
     * Generates a secure token
     *
 	 * @return string
 	 */
    protected function generateToken()
    {
        $bytes = false;
        if (function_exists('openssl_random_pseudo_bytes') && 0 !== stripos(PHP_OS, 'win')) {
            $bytes = openssl_random_pseudo_bytes(32, $strong);
            if (true !== $strong) {
                $bytes = false;
            }
        }

        // let's just hope we got a good seed
        if (false === $bytes) {
            $bytes = hash('sha256', uniqid(mt_rand(), true), true);
        }

        return base_convert(bin2hex($bytes), 16, 36);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getUsername();
    }
}