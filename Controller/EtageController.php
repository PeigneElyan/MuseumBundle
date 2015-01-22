<?php

// src/KE/MuseumBundle/Controller/EtageController.php

namespace KE\MuseumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class EtageController extends Controller
{
	 // On récupère tous les paramètres en arguments de la méthode
    public function viewSlugAction($slug, $year, $format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au
            slug '".$slug."', créée en ".$year." et au format ".$format."."
        );
    }
	
	public function viewAction($id)
	{
		return new Response("Affichage de l'annonce d'id : ".$id);
	}

	public function addAction()
    {
        $content = $this->get('templating')->render('KEMuseumBundle:Etage:index.html.twig');
		return new Response($content);
    }  
	
    public function indexAction()
    {
        $content = $this->get('templating')->render('KEMuseumBundle:Etage:index.html.twig');
		return new Response($content);
    }    
}
	?>