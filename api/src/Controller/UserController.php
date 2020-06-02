<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Annotation\ApiRessource;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

class UserController
{

    private $managerRegistry;
    private $request;

    public function __construct(ManagerRegistry $managerRegistry, RequestStack $requestStack)
    {
        $this->managerRegistry = $managerRegistry;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function __invoke(Request $data): User
    {
        $token = $this->request->get('token');
        $user = $this->managerRegistry->getRepository(User::class)->findOneBy(array('token' => $token));

        if(!$user) {
            throw $this->createNotFoundException(
                'No user found'
            );
        }

        $user->setIsActive(true);
        $user->setToken(null);
        $this->managerRegistry->getManager()->flush();

        return $user;
    }
}