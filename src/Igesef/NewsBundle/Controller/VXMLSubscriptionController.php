<?php

namespace Igesef\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Controller for subscription actions
 *
 * @author Ignacy Sawicki <igesef@gmail.com>
 * @Route("/vxml-subscribe")
 */
class VXMLSubscriptionController extends Controller
{
    /**
     * Subscription action, implemented using subdialog
     *
     * @Route("/subscribe", name="subscribe")
     * @Method("GET")
     */
    public function subscribeAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');

        return $this->render("IgesefNewsBundle:VXMLSubscription:subscribe.xml.twig", array(), $response);
    }
}
 