<?php

namespace App\Controller;

use App\Entity\Voiture;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VoitureController extends FOSRestController
{
    /**
     *get all voitures
     * @Rest\Get("/voiture")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAllVoitures(Request $request)
    {
       $voitures = $this->getDoctrine()
           ->getRepository(Voiture::class)
           ->findAll();


       if (empty($voitures)){

           return new JsonResponse("aucun voiture enregistré pour le moment",Response::HTTP_NOT_FOUND);
       }

        $reponses = [];

       foreach ($voitures as $voiture){

           $reponses = [
             'id' => $voiture->getId(),
             'nom' => $voiture->getNom(),
             'type' => $voiture->getType(),
             'couleur' => $voiture->getCouleur(),
             'nombrePlace' => $voiture->getNombrePlace(),
             'image' => $voiture->getImage()
           ];
       }

       return new JsonResponse($reponses, Response::HTTP_OK);
    }

    /**
     * show une voiture
     * @Rest\Get("/voiture/{id}")
     */

    public function getVoitureById(Request $request){

        $voiture = $this->get('doctrine.orm.entity_manager')
                        ->getRepository(Voiture::class)
                        ->find($request->get('id'));

        if (empty($voiture)){

            return new JsonResponse("voiture non trouve",Response::HTTP_NOT_FOUND);
        }

        $response [] = [
            'id' => $voiture->getId(),
             'nom' => $voiture->getNom(),
             'type' => $voiture->getType(),
             'couleur' => $voiture->getCouleur(),
             'nombrePlace' => $voiture->getNombrePlace(),
             'image' => $voiture->getImage()
        ];

        return new JsonResponse($response,Response::HTTP_OK);



    }
}
