<?php

// src/KE/MuseumBundle/Controller/ObjetController.php

namespace KE\MuseumBundle\Controller;

use KE\MuseumBundle\Entity\Objet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ObjetController extends Controller
{
	
	public function viewAction($id)
	{
		return new Response("Affichage de l'annonce d'id : ".$id);
	} 

	public function addAction(Request $request)
    {
		
		$objet = new Objet();

		$form = $this->get('form.factory')->createBuilder('form', $objet)
			->add('code','text')
			->add('nom','text')
			->add('longueur','text')
			->add('largeur','text')
			->add('hauteur','text')
			->add('save','submit')
			->getForm()
			;
			
		$form->handleRequest($request);
			
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();				
			$em->persist($objet);
			$em->flush();
			
			return $this->redirect($this->generateUrl('home'));

		}
			
		return $this->render('KEMuseumBundle:Objet:add.html.twig', array(
			'form' => $form->createView(),
		));
    } 
	
	public function indexEditAction(Request $request)
    {
        $form = $this->get('form.factory')->createBuilder('form')
			->add('code','text')
			->add('save','submit')
			->getForm()
			;
			
		$form->handleRequest($request);
			
		if ($form->isValid()) {
			$code = $form->get('code')->getData();
			return $this->redirect($this->generateUrl('objet_edit', array(
			'code' => $code)));
		}	
		return $this->render('KEMuseumBundle:Objet:indexEdit.html.twig', array(
			'form' => $form->createView()
		));
    }   
	
	public function editAction($code, Request $request)
    {
       $em = $this->getDoctrine()->getManager();

		$objet = $em->getRepository('KEMuseumBundle:Objet')->findOneByCode($code);

		if (null === $objet) {
			throw new NotFoundHttpException("L'objet de code ".$code." n'existe pas.");
		}

		
		$form = $this->get('form.factory')->createBuilder('form', $objet)
			->add('code','text')
			->add('nom','text')
			->add('longueur','text')
			->add('largeur','text')
			->add('hauteur','text')
			->add('save','submit')
			->getForm()
			;

		if ($form->handleRequest($request)->isValid()) {
			$em->flush();
			return $this->redirect($this->generateUrl('home'));
		}

		return $this->render('KEMuseumBundle:Objet:edit.html.twig', array(
			'form'   => $form->createView()
			));
    } 

	public function indexDeleteAction(Request $request)
    {
        $form = $this->get('form.factory')->createBuilder('form')
			->add('code','text')
			->add('save','submit')
			->getForm()
			;
			
		$form->handleRequest($request);
			
		if ($form->isValid()) {
			$code = $form->get('code')->getData();
			return $this->redirect($this->generateUrl('objet_delete', array(
			'code' => $code)));
		}	
		return $this->render('KEMuseumBundle:Objet:indexDelete.html.twig', array(
			'form' => $form->createView()
		));
    } 
	
	public function deleteAction($code, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

		$objet = $em->getRepository('KEMuseumBundle:Objet')->findOneByCode($code);

		if (null === $objet) {
			throw new NotFoundHttpException("L'objet de code ".$code." n'existe pas.");
		}

		
		$form = $this->get('form.factory')->createBuilder('form', $objet)
			->add('code','text')
			->add('nom','text')
			->add('longueur','text')
			->add('largeur','text')
			->add('hauteur','text')
			->add('save','submit')
			->getForm()
			;

		if ($form->handleRequest($request)->isValid()) {
			$em->remove($objet);
			$em->flush();
			return $this->redirect($this->generateUrl('home'));
		}

		return $this->render('KEMuseumBundle:Objet:delete.html.twig', array(
			'form'   => $form->createView()
			));
    } 
	
	}
	?>