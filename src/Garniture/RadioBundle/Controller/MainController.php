<?php

namespace Garniture\RadioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * main controller.
 *
 * @Route("/index")
 */
class MainController extends Controller
{

    /**
     * Lists all Categorie entities.
     *
     * @Route("/", name="categorie")
     * @Template()
     */
    public function indexAction()
    {
        
       
        return $this->render('GarnitureRadioBundle:Main:main.html.twig', array(
            
            )
        );
    }
   
}
