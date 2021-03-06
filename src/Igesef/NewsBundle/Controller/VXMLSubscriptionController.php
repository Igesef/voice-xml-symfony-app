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
        $categories = $this->getDoctrine()->getManager()->getRepository('IgesefNewsBundle:Category')->findAll();

        return $this->render(
            "IgesefNewsBundle:VXMLSubscription:subscribe.xml.twig",
            array('categories' => $categories),
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
        $secondCategory = $request->get('subscription_secondCategory');
        $frequency = $request->get('subscription_frequency');
        $phoneNumber = $request->get('subscription_phoneNumber');
        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('IgesefNewsBundle:Category');

        /** @var Category $category */
        $category = $categoryRepository->findOneBy(array('name' => $categoryName));

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity');
        }


        $subscription = new Subscription();

        if ($secondCategory !== 'none') {
            $second = $categoryRepository->findOneBy(array('name' => $secondCategory));
            $subscription->addCategory($second);
        }
        $subscription->addCategory($category)
            ->setFrequency($frequency)
            ->setPhoneNumber($phoneNumber);

        $em->persist($subscription);
        $em->flush();

        $response->headers->set('Content-Type', 'text/xml');

        return $this->render("IgesefNewsBundle:VXMLSubscription:subscribe-parse.xml.twig", array(), $response);
    }

    /**
     * Action for subscribe subdialog grammar
     *
     * @Route("/grammar", name="subscribe-grammar")
     * @Method("GET")
     */
    public function grammarAction()
    {
        $categories = $this->getDoctrine()->getManager()->getRepository('IgesefNewsBundle:Category')->findAll();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/grammar-xml');

        return $this->render(
            "IgesefNewsBundle:VXMLSubscription:grammar.xml.twig",
            array('categories' => $categories),
            $response
        );
    }
}
 