<?php

namespace KE\MuseumBundle\Controller;

use KE\MuseumBundle\Entity\Armoire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\Query\ResultSetMapping;

class ArmoireController extends Controller
{

	public function addAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$armoires = $em->getRepository('KEMuseumBundle:Armoire')->findAll();
		$armoire = new Armoire();
		$erreur = false;

		$form = $this->get('form.factory')->createBuilder('form', $armoire)
			->add('code','text')
			->add('save','submit')
			->getForm()
			;
			
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			foreach($armoires as $val){
				if($armoire->getCode() == $val->getCode()){
					$erreur = true;
				}
			}
			if($erreur){
				return $this->redirect($this->generateUrl('armoire_add_erreur', array('code' => $armoire->getCode() )));
			}
			else{
			
				$em = $this->getDoctrine()->getManager();		
				$em->persist($armoire);
				$em->flush();
			
				return $this->redirect($this->generateUrl('home_action', array('type' => 'succes', 'codeMessage' => '7')));
			}
		}
			
			return $this->render('KEMuseumBundle:Armoire:add.html.twig', array(
			'form' => $form->createView()
		));
    } 
	
	public function editAction($code, Request $request)
    {
		$em = $this->getDoctrine()->getManager();

		$armoire = $em->getRepository('KEMuseumBundle:Armoire')->findOneByCode($code);

		if (null === $armoire) {
			throw new NotFoundHttpException("L'armoire de numéro ".$code." n'existe pas.");
		}

		
		$form = $this->get('form.factory')->createBuilder('form', $armoire)
			->add('code','text')
			->add('save','submit')
			->getForm()
			;

		if ($form->handleRequest($request)->isValid()) {
			$em->flush();
			return $this->redirect($this->generateUrl('home_action', array('type' => 'succes', 'codeMessage' => '9')));
		}

		return $this->render('KEMuseumBundle:Armoire:edit.html.twig', array(
			'form'   => $form->createView(),
			'armoire'  => $armoire
			));
    } 

	public function deleteAction($code, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

		$armoire = $em->getRepository('KEMuseumBundle:Armoire')->findOneByCode($code);
		$etages = $em->getRepository('KEMuseumBundle:Etage')->findByIdArmoire($armoire->getId());
		$ordres = $em->getRepository('KEMuseumBundle:Ordre')->findAll();

		if (null === $code) {
			throw new NotFoundHttpException("L'armoire de numéro ".$code." n'existe pas.");
		}

		
		$form = $this->get('form.factory')->createBuilder('form', $armoire)
			->add('code','text')
			->add('save','submit')
			->getForm()
			;

		if ($form->handleRequest($request)->isValid()) {
			foreach ($etages as $et) {
				foreach($ordres as $or) {
					if($or->getIdEtage() == $et->getId())
					{
						$or->setPourcent(null);
						$or->setIdEtage(null);
						$em->persist($or);
					}
				}
				$em->remove($et);
			}
			$em->remove($armoire);
			$em->flush();
			return $this->redirect($this->generateUrl('home_action', array('type' => 'succes', 'codeMessage' => '8')));
		}

		return $this->render('KEMuseumBundle:Armoire:delete.html.twig', array(
			'form'   => $form->createView()
			));
    } 
	
	public function indexConsultAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$armoires = $em->getRepository('KEMuseumBundle:Armoire')->findAll();
		$etages = $em->getRepository('KEMuseumBundle:Etage')->findAll();

        $form = $this->get('form.factory')->createBuilder('form')
			->add('code','text')
			->add('save','submit')
			->getForm()
			;
			
		$form->handleRequest($request);
			
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$code = $form->get('code')->getData();
			$armoires = $em->getRepository('KEMuseumBundle:Armoire')->findOneByCode($code);

			if($armoire == null)
			{
				return $this->render('KEMuseumBundle:Main:erreur.html.twig', array(
				'type' => "étage",
				'code' => $code));
			}
			else
			{	
				return $this->redirect($this->generateUrl('armoire_consult', array(
				'code' => $code)));
			}	
		}	
		return $this->render('KEMuseumBundle:Armoire:indexConsult.html.twig', array(
			'form' => $form->createView(), 'armoires' => $armoires, 'etages' => $etages
		));
    }   
	
	public function consultAction($code, Request $request)
    {
       $em = $this->getDoctrine()->getManager();

		$armoire = $em->getRepository('KEMuseumBundle:Armoire')->findOneByCode($code);
		$etages = $em->getRepository('KEMuseumBundle:Etage')->findByIdArmoire($armoire->getId(),array('ordreArmoire'=>'ASC'));
		$ordres = $em->getRepository('KEMuseumBundle:Ordre')->findAllASC();
		$objets = $em->getRepository('KEMuseumBundle:Objet')->findAll();

		if (null === $armoire) {
			throw new NotFoundHttpException("L'armoire de numéro ".$code." n'existe pas.");
		}

		return $this->render('KEMuseumBundle:Armoire:consult.html.twig', array(
			'armoire' => $armoire,'etages' => $etages, 'ordres' => $ordres, 'objets' => $objets
			));
    } 	
	
	
		public function ordreUpAction($idArmoire, $idEtage){
	
		$em = $this->getDoctrine()->getManager();
		$armoire = $em->getRepository('KEMuseumBundle:Armoire')->findOneById($idArmoire);
		$etage = $em->getRepository('KEMuseumBundle:Etage')->findOneById($idEtage);
		$ordreUp = $em->getRepository('KEMuseumBundle:Etage')->findOneBy(array(
																	'idArmoire' => $idArmoire,
																	'ordreArmoire' => ($etage->getOrdreArmoire())-1
																	));
	
		$ordreUp->setOrdreArmoire($etage->getOrdreArmoire());
		$etage->setOrdreArmoire(($etage->getOrdreArmoire())-1);
		
		$em->persist($etage);
		$em->persist($ordreUp);
		$em->flush();
		
		return $this->redirect($this->generateUrl('armoire_consult', array(
				'code' => $armoire->getCode())));
	}
		
		public function ordreDownAction($idArmoire, $idEtage){
	
		$em = $this->getDoctrine()->getManager();
		$armoire = $em->getRepository('KEMuseumBundle:Armoire')->findOneById($idArmoire);
		$etage = $em->getRepository('KEMuseumBundle:Etage')->findOneById($idEtage);		
		$ordreDown = $em->getRepository('KEMuseumBundle:Etage')->findOneBy(array(
																	'idArmoire' => $idArmoire,
																	'ordreArmoire' => ($etage->getOrdreArmoire())+1
																	));
		
		$ordreDown->setOrdreArmoire($etage->getOrdreArmoire());
		$etage->setOrdreArmoire(($etage->getOrdreArmoire())+1);
		
		$em->persist($etage);
		$em->persist($ordreDown);
		$em->flush();
		
		return $this->redirect($this->generateUrl('armoire_consult', array(
				'code' => $armoire->getCode())));
	}
		
}
?>
