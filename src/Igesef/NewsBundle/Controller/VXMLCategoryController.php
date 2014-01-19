<?php

namespace Igesef\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * VoiceXML controller for category actions
 *
 * @author Ignacy Sawicki <igesef@gmail.com>
 * @Route("/vxml-category")
 */
class VXMLCategoryController extends Controller
{

    /**
     * Main action of the application
     *
     * @Route("/", name="main")
     * @Method("GET")
     * @return Response
     */
    public function mainAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');

        return $this->render("IgesefNewsBundle:VXMLCategory:main.xml.twig", array(), $response);
    }
}
 