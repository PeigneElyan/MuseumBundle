<?php

// src/KE/MuseumBundle/Controller/ObjetController.php

namespace KE\MuseumBundle\Controller;

use KE\MuseumBundle\Entity\Objet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ObjetController extends Controller
{
	
	public function viewAction($id)
	{
		return new Response("Affichage de l'annonce d'id : ".$id);
	} 
	
	public function editAction()
    {
        $content = $this->get('templating')->render('KEMuseumBundle:Objet:index.html.twig');
		return new Response($content);
    } 
	
	public function deleteAction()
    {
        $content = $this->get('templating')->render('KEMuseumBundle:Objet:index.html.twig');
		return new Response($content);
    } 
	
    public function indexAction()
    {
        $content = $this->get('templating')->render('KEMuseumBundle:Objet:index.html.twig');
		return new Response($content);
    }   

	public function addAction(Request $request)
    {
		
		$objet = new Objet();

		$form = $this->get('form.factory')->createBuilder('form', $objet)
			->add('nom','text')
			->add('longueur','text')
			->add('largeur','text')
			->add('save','submit')
			->getForm()
			;
			
		$form->handleRequest($request);
			
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();				
			$em->persist($advert);
			$em->flush();
		}
			
		return $this->render('KEMuseumBundle:Objet:index.html.twig', array(
			'form' => $form->createView(),
		));
    } 
}
	?>