<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GenusController extends Controller
{
    /**
     * @Route("/genus/new")
     */
    public function newAction()
    {
        $genus = new Genus();
        $genus->setName('Octopus'.rand(1, 100));
        $genus->setSubFamily('Octopodinae');
        $genus->setSpeciesCount(rand(100, 99999));

        $em = $this->getDoctrine()->getManager();
        $em->persist($genus);
        $em->flush();

        return new Response('<html><body>Genus created!</body></html>');
    }

    /**
     * @Route("/genus")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
//        $genuses = $em->getRepository('AppBundle\Entity\Genus')
//            ->findAll();
        $genuses = $em->getRepository('AppBundle:Genus')
            ->findAll();
//        dump($genuses);die;

        return $this->render('genus/list.html.twig', ['genuses' => $genuses]);
    }

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
        $funFact = 'Octopuses can change the color of their body in just *three-tenths* of a second!';
////        $funFact = $this->container->get('markdown.parser')->transform($funFact);
//        $funFact = $this->get('markdown.parser')->transform($funFact);

        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
        $key = md5($funFact);

        if($cache->contains($key)){
            $funFact = $cache->fetch($key);
        }else{
            sleep(1);
            $funFact = $this->get('markdown.parser')->transform($funFact);
            $cache->save($key, $funFact);
        }

        return $this->render('genus/show.html.twig', array('name' => $genusName, 'funFact' => $funFact));
    }

    /**
     * @Route("/genus/{genusName}/notes", name="genus_show_notes")
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