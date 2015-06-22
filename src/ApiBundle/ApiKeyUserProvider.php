<?php

namespace ApiBundle;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use UserBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class ApiKeyUserProvider implements UserProviderInterface
{
    protected $doctrine;
    protected $user;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }


    public function getUsernameForApiKey($apiKey)
    {
        $user = $this->doctrine->getRepository('UserBundle:User')
            ->find($apiKey);

        $this->user = $user;

        return $user->getUsername();
    }

    public function loadUserByUsername($username)
    {
        if ($username !== $this->user->getUsername()) {
            throw new UnsupportedUserException('Username mismatch!');
        }

        $this->user->addRole('ROLE_API');

        return $this->user;

        // return new User(
        //     $username,
        //     null,
        //     // the roles for the user - you may choose to determine
        //     // these dynamically somehow based on the user
        //     array('ROLE_USER')
        // );
    }

    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return User::CLASS === $class;
    }
}
