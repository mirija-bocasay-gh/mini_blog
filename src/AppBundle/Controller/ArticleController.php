<?php
namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Constant\ManipulationActionType;

/**
 * Class ArticleController
 * @package AppBundle\Controller
 *
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * List article
     *
     * @Route("/liste", name="article_list")
     *
     * @return Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articleList = $em->getRepository('AppBundle\Entity\Article')->findAll();

        return $this->render('article/list.html.twig', array(
            'article_list' => $articleList,
        ));
    }

    /**
     * Article detail
     *
     * @Route("/detail/{id}", name="article_detail", requirements={"id": "\d+"})
     *
     * @param int $id
     * @return Response
     */
    public function detailAction($id)
    {

    }

    /**
     * Add article
     *
     * @Route("/ajout", name="article_add")s
     *
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $formGenerator = $this->get('AppBundle\Service\FormGenerator\ArticleFormGenerator');
        $form = $formGenerator->generateForCreate('create_article_form');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articleManager = $this->get('AppBundle\Manager\ArticleManager');
            $articleManager->create($form->getData());

            return $this->redirectToRoute('article_list');
        }

        return $this->render('article/manipulate.html.twig', array(
            'create_article_form' => $form->createView(),
            'action_type' => ManipulationActionType::ACTION_ADD,
        ));
    }
}