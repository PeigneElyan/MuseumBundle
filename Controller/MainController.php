<?php

// src/KE/MuseumBundle/Controller/MainController.php

namespace KE\MuseumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
	 // On r�cup�re tous les param�tres en arguments de la m�thode
    public function viewSlugAction($slug, $year, $format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au
            slug '".$slug."', cr��e en ".$year." et au format ".$format."."
        );
    }
	
	public function menuAction($limit)
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la r�cup�rera depuis la BDD !
    $listAdverts = array(
      array('id' => 2, 'title' => 'Recherche d�veloppeur Symfony2'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('KEMuseumBundle:Main:menu.html.twig', array(
      // Tout l'int�r�t est ici : le contr�leur passe
      // les variables n�cessaires au template !
      'listAdverts' => $listAdverts
    ));
  }
	
	public function viewAction($id)
	{
		return new Response("Affichage de l'annonce d'id : ".$id);
	}

    public function indexAction()
    {
        $content = $this->get('templating')->render('KEMuseumBundle:Main:index.html.twig');
		return new Response($content);
    }    
}
	?>