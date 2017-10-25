<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GenusController extends Controller
{
    /**
     * @Route("/genus/{genusName}")
     */
    public function showAction($genusName)
    {
//////        $notes = [
//////            'Octopus asked me a riddle, outsmarted me',
//////            'I counted 8 legs... as they wrapped around me',
//////            'Inked!'
//////        ];


////        return new Response("Under the sea!!!! Oh Yeah!!! <br/> The genus: ".$genusName);
//        $templating = $this->container->get('templating');
////        $this->container->get('templating')
//        $html = $templating->render('genus/show.html.twig', array('name' => $genusName));
//
//        return new Response($html);
        return $this->render('genus/show.html.twig', array('name' => $genusName));
    }

    /**
     * @Route("/genus/{genusName}/notes")
     * @Method("GET")
     */
    public function getNotesAction($genusName)
    {
        $notes = [
            ['id' => 1, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Octopus asked me a riddle, outsmarted me', 'date' => 'Dec. 10, 2015'],
            ['id' => 2, 'username' => 'AquaWeaver', 'avatarUri' => '/images/ryan.jpeg', 'note' => 'I counted 8 legs... as they wrapped around me', 'date' => 'Dec. 1, 2015'],
            ['id' => 3, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Inked!', 'date' => 'Aug. 20, 2015'],
        ];

        $data = [
            'notes' => $notes
        ];

//        return new Response(json_encode($data)); //está retornando os dados como json
        return new JsonResponse($data); //também retorna os dados como json
    }
}