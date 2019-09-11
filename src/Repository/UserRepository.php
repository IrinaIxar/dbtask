<?php

namespace Repository;
use Entity\User;

class UserRepository
{
    protected $em;
    protected $userRepository;

    public function __construct()
    {
        $this->em = \App\DoctrineEM::getInstance();
        $this->userRepository = $this->em->getRepository('\Entity\User');
    }

    /**
     * Users list
     *
     * @return array users
     */
    public function findAll()
    {
        return $this->userRepository->findAll();
    }

    /**
     * User by login
     *
     * @param  string  $login  user login
     * @return User
     */
    public function findByLogin($login)
    {
        return $this->userRepository->findOneBy(['login' => $login]);
    }

    /**
     * Adds new user
     *
     * @param $request
     * @return string
     */
    public function add($request)
    {
        $params = $request->getParsedBody();
        $user = new User();
        $user->setLogin($params['addLogin']);
        $user->setPassword(md5($params['addPassword']));
        $user->setDeleted(0);

        $this->em->persist($user);
        $this->em->flush();

        return $this->em->contains($user);
    }
}