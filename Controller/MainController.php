<?php

// src/KE/MuseumBundle/Controller/MainController.php

namespace KE\MuseumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{

    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		$etages = $em->getRepository('KEMuseumBundle:Etage')->findAll();
		$objets = $em->getRepository('KEMuseumBundle:Objet')->findAll();
		$ordres = $em->getRepository('KEMuseumBundle:Ordre')->findAll();

       
	   return $this->render('KEMuseumBundle:Main:index.html.twig', array(
			'etages' => $etages,
			'objets' => $objets,
			'ordres' => $ordres
		));
    }    
}
	?>