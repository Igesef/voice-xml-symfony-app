<?php

namespace Igesef\NewsBundle\Controller;

use Igesef\NewsBundle\Entity\Category;
use Igesef\NewsBundle\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

        return $this->render(
            "IgesefNewsBundle:VXMLSubscription:subscribe.xml.twig",
            array(),
            $response
        );
    }

    /**
     * Subscription action, implemented using subdialog
     *
     * @Route("/subscribe-parse", name="subscribe-parse")
     * @Method("GET")
     */
    public function subscribeParseAction(Request $request)
    {
        $response = new Response();
        $categoryName = $request->get('category');
        $frequency = $request->get('frequency');
        $phoneNumber = $request->get('phoneNumber');
        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $this->em->getRepository('IgesefNewsBundle:Category');


        /** @var Category $category */
        $category = $categoryRepository->findOneBy(array('name' => $categoryName));

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity');
        }

        $subscription = new Subscription();
        $subscription->addCategory($category)
            ->setFrequency($frequency)
            ->setPhoneNumber($phoneNumber);

        $em->persist($subscription);
        $em->flush();

        $response->headers->set('Content-Type', 'text/xml');

        return $this->render("IgesefNewsBundle:VXMLSubscription:subscribe-parse.xml.twig", array(), $response);
    }
}
 