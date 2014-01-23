<?php

namespace Igesef\NewsBundle\Controller;

use Igesef\NewsBundle\Entity\Category;
use Igesef\NewsBundle\Entity\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

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
     *
     * @return Response
     */
    public function mainAction()
    {
        $response = new Response();

        // Fetching all main categories
        $categories = $this->getRepository()
            ->findAllMainCategories();

        $response->headers->set('Content-Type', 'text/xml');

        return $this->render(
            "IgesefNewsBundle:VXMLCategory:main.xml.twig",
            array('categories' => $categories),
            $response
        );
    }

    /**
     * Lists subcategories for selection or directly forwards to news for category action if none subcategories found
     *
     * @Route("/subcategories", name="subcategories")
     * @Method("GET")
     *
     * @param Request $request
     *
     * @throws NotFoundHttpException
     * @throws MethodNotAllowedException
     * @return Response
     */
    public function subcategoriesAction(Request $request)
    {
        if ($request->getMethod() == 'GET') {
            // category is in query->parameters with "category" key
            $categoryName = $request->get('category');
            $repository = $this->getRepository();

            if ($categoryName == 'news of the day') {
                return $this->forward(
                    'IgesefNewsBundle:VXMLNewsOfTheDay:index'
                );
            }
            /** @var Category $category */
            $category = $repository->findOneBy(array('name' => $categoryName));

            if (!$category) {
                throw $this->createNotFoundException('Unable to find Category entity');
            }

            $categories = $repository->findSubcategoriesByCategory($category);


            if (!empty($categories)) {
                $response = new Response();
                $response->headers->set('Content-Type', 'text/xml');

                return $this->render(
                    "IgesefNewsBundle:VXMLCategory:subcategories.xml.twig",
                    array('subcategories' => $categories, 'category' => $categoryName),
                    $response
                );
            } else {
                $response = $this->forward(
                    'IgesefNewsBundle:VXMLNews:getNewsByCategory',
                    array(),
                    array('category' => $categoryName)
                );

                return $response;
            }

        } else {
            throw new MethodNotAllowedException('Cannot access subcategories without posting main category');
        }
    }

    /**
     * Returns category repository
     *
     * @return CategoryRepository
     */
    private function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('IgesefNewsBundle:Category');
    }
}
 