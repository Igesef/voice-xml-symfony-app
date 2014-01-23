<?php

namespace Igesef\NewsBundle\Controller;

use Igesef\NewsBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * VoiceXML controller for news actions
 *
 * @author Ignacy Sawicki <igesef@gmail.com>
 * @Route("/vxml-newsoftheday")
 */
class VXMLNewsOfTheDayController extends Controller
{

   /**
     * Fetches news by category
     *
     * @Route("/", name="daynews")
     * @Method("GET")
     *
     * @return Response
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('IgesefNewsBundle:NewsOfTheDay');

        $news = $repository->findAll();

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');

        return $this->render(
            "IgesefNewsBundle:VXMLNewsOfTheDay:index.xml.twig",
            array('entities' => $news),
            $response
        );
    }
}
 