<?php

// src/KE/MuseumBundle/Controller/ObjetController.php

namespace KE\MuseumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ObjetController extends Controller
{
	 // On r�cup�re tous les param�tres en arguments de la m�thode
    public function viewSlugAction($slug, $year, $format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au
            slug '".$slug."', cr��e en ".$year." et au format ".$format."."
        );
    }
	
	public function viewAction($id)
	{
		return new Response("Affichage de l'annonce d'id : ".$id);
	}

	public function addAction()
    {
        $content = $this->get('templating')->render('KEMuseumBundle:Objet:index.html.twig');
		return new Response($content);
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
}
	?>