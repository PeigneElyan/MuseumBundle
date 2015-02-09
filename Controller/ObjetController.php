<?php

// src/KE/MuseumBundle/Controller/ObjetController.php

namespace KE\MuseumBundle\Controller;

use KE\MuseumBundle\Entity\Objet;
use KE\MuseumBundle\Entity\Ordre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ObjetController extends Controller
{
	

	public function addAction(Request $request)
    {
		
		$objet = new Objet();
		$ordre = new Ordre();

		$form = $this->get('form.factory')->createBuilder('form', $objet)
			->add('code','text')
			->add('nom','text')
			->add('longueur','text')
			->add('profondeur','text')
			->add('hauteur','text')
			->add('save','submit')
			->getForm()
			;
			
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();				
			$em->persist($objet);
			$em->flush();
			$ordre->setIdObjet($objet->getId());
			$em->persist($ordre);
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
		$ordre = $em->getRepository('KEMuseumBundle:Ordre')->findOneByIdObjet($objet->getId());

		
		if (null === $objet) {
			throw new NotFoundHttpException("L'objet de code ".$code." n'existe pas.");
		}

		$dejaPlace = false;
		
		if($ordre->getIdEtage() != NULL)
		{
			$dejaPlace = true;
		}
		
		
		$form = $this->get('form.factory')->createBuilder('form', $objet)
			->add('code','text')
			->add('nom','text')
			->add('longueur','text')
			->add('profondeur','text')
			->add('hauteur','text')
			->add('save','submit')
			->getForm()
			;

		if ($form->handleRequest($request)->isValid()) {
			$em->flush();
			return $this->redirect($this->generateUrl('home'));
		}

		return $this->render('KEMuseumBundle:Objet:edit.html.twig', array(
			'form'   => $form->createView(),
			'dejaPlace' => $dejaPlace
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
		$ordre = $em->getRepository('KEMuseumBundle:Ordre')->findOneByIdObjet($objet->getId());
		$etage = $em->getRepository('KEMuseumBundle:Etage')->findOneById($ordre->getIdEtage());
		
		if (null === $objet) {
			throw new NotFoundHttpException("L'objet de code ".$code." n'existe pas.");
		}

		
		$form = $this->get('form.factory')->createBuilder('form', $objet)
			->add('code','text')
			->add('nom','text')
			->add('longueur','text')
			->add('profondeur','text')
			->add('hauteur','text')
			->add('save','submit')
			->getForm()
			;

		if ($form->handleRequest($request)->isValid()) {
			$etage->setPlaceDisponible($etage->getPlaceDisponible()+$objet->getLongueur());
			$em->persist($etage);
			$em->remove($objet);
			$em->remove($ordre);
			$em->flush();
			return $this->redirect($this->generateUrl('home'));
		}

		return $this->render('KEMuseumBundle:Objet:delete.html.twig', array(
			'form'   => $form->createView()
			));
    } 
	
	public function indexPlaceAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$objets = $em->getRepository('KEMuseumBundle:Objet')->findAll();
		$ordres = $em->getRepository('KEMuseumBundle:Ordre')->findAll();
		
        $form = $this->get('form.factory')->createBuilder('form')
			->add('code','text')
			->add('save','submit')
			->getForm()
			;
			
		$form->handleRequest($request);
			
		if ($form->isValid()) {
			$code = $form->get('code')->getData();
			return $this->redirect($this->generateUrl('objet_place', array(
			'code' => $code)));
		}	
		return $this->render('KEMuseumBundle:Objet:indexPlace.html.twig', array(
			'form' => $form->createView(), 'ordres' => $ordres, 'objets' => $objets
		));
    }   
	
	
	public function placeAction($code, Request $request)
    {
       $em = $this->getDoctrine()->getManager();

		$objet = $em->getRepository('KEMuseumBundle:Objet')->findOneByCode($code);
		$etages = $em->getRepository('KEMuseumBundle:Etage')->findAll();

		if (null === $objet) {
			throw new NotFoundHttpException("L'objet de code ".$code." n'existe pas.");
		}

		return $this->render('KEMuseumBundle:Objet:place.html.twig', array(
			'etages' => $etages , 'objet' => $objet
			));
    } 
	
	}
	?>