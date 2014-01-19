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
use Symfony\Component\Translation\Exception\InvalidResourceException;

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
     * Main action of the application
     *
     * @Route("/subcategories", name="subcategories")
     * @Method("POST")
     *
     * @param Request $request
     *
     * @throws NotFoundHttpException
     * @throws MethodNotAllowedException
     * @return Response
     */
    public function subcategoriesAction(Request $request)
    {

        $form = $this->createFormBuilder()
            ->add('category', 'text')
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->submit($request);
            // data is an array with "category" key
            $data = $form->getData();

            $categoryName = $data['category'];
            $repository = $this->getRepository();

            /** @var Category $category */
            $category = $repository->findOneBy(array('name' => $categoryName));

            if (!$category) {
                throw $this->createNotFoundException('Unable to find Category entity');
            }

            $categories = $repository->findSubcategoriesByCategory($category);

            $response = new Response();
            $response->headers->set('Content-Type', 'text/xml');

            return $this->render(
                "IgesefNewsBundle:VXMLCategory:subcategories.xml.twig",
                array('categories' => $categories),
                $response
            );

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
 