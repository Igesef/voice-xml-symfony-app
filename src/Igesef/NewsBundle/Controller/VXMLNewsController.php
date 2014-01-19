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
 * @Route("/vxml-news")
 */
class VXMLNewsController extends Controller
{

   /**
     * Fetches news by category
     *
     * @Route("/by-category", name="news-by-category")
     * @Method("GET")
     *
     * @param Request $request
     *
     * @throws NotFoundHttpException
     * @throws MethodNotAllowedException
     * @return Response
     */
    public function getNewsByCategoryAction(Request $request)
    {
        if ($request->getMethod() == 'GET') {
            // category is in query->parameters with "category" key
            $categoryName = $request->get('category');
            $categoryRepository = $this->getDoctrine()->getManager()->getRepository('IgesefNewsBundle:Category');
            $repository = $this->getDoctrine()->getManager()->getRepository('IgesefNewsBundle:News');

            /** @var Category $category */
            $category = $categoryRepository->findOneBy(array('name' => $categoryName));

            if (!$category) {
                throw $this->createNotFoundException('Unable to find Category entity');
            }

            $news = $repository->findNewsByCategory($category);

            $response = new Response();
            $response->headers->set('Content-Type', 'text/xml');

            return $this->render(
                "IgesefNewsBundle:VXMLNews:by-category.xml.twig",
                array('news' => $news, 'category' => $categoryName),
                $response
            );

        } else {
            throw new MethodNotAllowedException('You need to provide news categoru');
        }
    }
}
 