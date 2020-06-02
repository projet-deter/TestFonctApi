<?php

namespace App\Controller;

use App\Entity\Offer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Annotation\ApiRessource;
use App\Repository\OfferRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;



class OfferController
{

    private $managerRegistry;
    private $request;

    public function __construct(ManagerRegistry $managerRegistry, RequestStack $requestStack)
    {
        $this->managerRegistry = $managerRegistry;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function __invoke(Request $data): Offer
    {
        $token = $this->request->get('token');
        $offer = $this->managerRegistry->getRepository(Offer::class)->findOneBy(array('token' => $token));

        if(!$offer) {
            throw $this->createNotFoundException(
                'No offer found'
            );
        }

        return $offer;
    }
}