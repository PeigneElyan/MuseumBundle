<?php

// src/KE/MuseumBundle/Controller/EtageController.php

namespace KE\MuseumBundle\Controller;

use KE\MuseumBundle\Entity\Etage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\Query\ResultSetMapping;

class EtageController extends Controller
{
		
	public function addAction(Request $request)
    {
		
		$etage = new Etage();

		$form = $this->get('form.factory')->createBuilder('form', $etage)
			->add('code','text')
			->add('longueur','text')
			->add('largeur','text')
			->add('hauteur','text')
			->add('save','submit')
			->getForm()
			;
			
		$form->handleRequest($request);
			
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();		
			$etage->onCreate();			
			$em->persist($etage);
			$em->flush();
			
			return $this->redirect($this->generateUrl('home'));
		}
			
		return $this->render('KEMuseumBundle:Etage:add.html.twig', array(
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
			return $this->redirect($this->generateUrl('etage_edit', array(
			'code' => $code)));
		}	
		return $this->render('KEMuseumBundle:Etage:indexEdit.html.twig', array(
			'form' => $form->createView()
		));
    }   
	
	public function editAction($code, Request $request)
    {
       $em = $this->getDoctrine()->getManager();

		$etage = $em->getRepository('KEMuseumBundle:Etage')->findOneByCode($code);

		if (null === $etage) {
			throw new NotFoundHttpException("L'étage de numéro ".$code." n'existe pas.");
		}

		
		$form = $this->get('form.factory')->createBuilder('form', $etage)
			->add('code','text')
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

		return $this->render('KEMuseumBundle:Etage:edit.html.twig', array(
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
			return $this->redirect($this->generateUrl('etage_delete', array(
			'code' => $code)));
		}	
		return $this->render('KEMuseumBundle:Etage:indexDelete.html.twig', array(
			'form' => $form->createView()
		));
    } 
	
	public function deleteAction($code, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

		$etage = $em->getRepository('KEMuseumBundle:Etage')->findOneByCode($code);

		if (null === $code) {
			throw new NotFoundHttpException("L'étage de numéro ".$code." n'existe pas.");
		}

		
		$form = $this->get('form.factory')->createBuilder('form', $etage)
			->add('code','text')
			->add('longueur','text')
			->add('largeur','text')
			->add('hauteur','text')
			->add('save','submit')
			->getForm()
			;

		if ($form->handleRequest($request)->isValid()) {
			$em->remove($etage);
			$em->flush();
			return $this->redirect($this->generateUrl('home'));
		}

		return $this->render('KEMuseumBundle:Etage:delete.html.twig', array(
			'form'   => $form->createView()
			));
    } 
	
	public function placementObjetAction($codeEtage, $codeObjet){
	
		$em = $this->getDoctrine()->getManager();
		$objet = $em->getRepository('KEMuseumBundle:Objet')->findOneByCode($codeObjet);
		$etage = $em->getRepository('KEMuseumBundle:Etage')->findOneByCode($codeEtage);
		$ordre = $em->getRepository('KEMuseumBundle:Ordre')->findOneByIdObjet($objet->getId());
		
		$ordre->setIdEtage($etage->getId());
		$etage->setPlaceDisponible($etage->getPlaceDisponible() - $objet->getLongueur());
		
		$count = $em->getRepository('KEMuseumBundle:Ordre')->getNb($etage->getId());
		
		if($count == null){
			$count=0;
		}
		$count+=1;
		$ordre->setOrdre($count);
		
		$em->persist($ordre);
		$em->persist($etage);
		$em->flush();
	
		return $this->redirect($this->generateUrl('etage_consult', array(
			'code' => $codeEtage)));
	}
	
	public function retirerObjetAction($codeEtage, $codeObjet){
	
		$em = $this->getDoctrine()->getManager();
		$objet = $em->getRepository('KEMuseumBundle:Objet')->findOneByCode($codeObjet);
		$etage = $em->getRepository('KEMuseumBundle:Etage')->findOneByCode($codeEtage);
		$ordre = $em->getRepository('KEMuseumBundle:Ordre')->findOneByIdObjet($objet->getId());
		$ordres = $em->getRepository('KEMuseumBundle:Ordre')->findByIdEtage($etage->getId());
		
		foreach ($ordres as &$or) {
			if($or->getOrdre() > $ordre->getOrdre() ){
				$or->setOrdre($or->getOrdre() - 1);
				$em->persist($or);
			}
		}
		
		$etage->setPlaceDisponible($etage->getPlaceDisponible() + $objet->getLongueur());
	
		$ordre->setIdEtage(null);
		$ordre->setOrdre(null);
		
		$em->persist($ordre);
		$em->persist($etage);
		
		$em->flush();
	
		return $this->redirect($this->generateUrl('etage_consult', array(
			'code' => $codeEtage)));
	}
	
	public function indexConsultAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$etages = $em->getRepository('KEMuseumBundle:Etage')->findAll();
		
        $form = $this->get('form.factory')->createBuilder('form')
			->add('code','text')
			->add('save','submit')
			->getForm()
			;
			
		$form->handleRequest($request);
			
		if ($form->isValid()) {
			$code = $form->get('code')->getData();
			return $this->redirect($this->generateUrl('etage_consult', array(
			'code' => $code)));
		}	
		return $this->render('KEMuseumBundle:Etage:indexConsult.html.twig', array(
			'form' => $form->createView(), 'etages' => $etages
		));
    }   
	
	public function consultAction($code, Request $request)
    {
       $em = $this->getDoctrine()->getManager();

		$etage = $em->getRepository('KEMuseumBundle:Etage')->findOneByCode($code);
		$ordres = $em->getRepository('KEMuseumBundle:Ordre')->findByIdEtage($etage->getId());
		$objets = $em->getRepository('KEMuseumBundle:Objet')->findAll($code);

		if (null === $etage) {
			throw new NotFoundHttpException("L'étage de numéro ".$code." n'existe pas.");
		}


		return $this->render('KEMuseumBundle:Etage:consult.html.twig', array(
			'etage' => $etage, 'ordres' => $ordres, 'objets' => $objets
			));
    } 
	
	}
	?>