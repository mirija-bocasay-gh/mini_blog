<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function detailAction(Request $request, $id)
    {
        $articleChecker = $this->get('AppBundle\Service\DataChecker\ArticleChecker');
        $article = $articleChecker->checkIfExists($id);
        if (is_null($article)) {
            throw new NotFoundHttpException();
        }

        $commentFormGenerator = $this->get('AppBundle\Service\FormGenerator\CommentFormGenerator');
        $form = $commentFormGenerator->generateForCreate('create_comment_form');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
            $commentManager = $this->get('AppBundle\Manager\CommentManager');
            $commentManager->create($form->getData(), $article);

            return $this->redirectToRoute('article_detail', array('id' => $id));
        }

        return $this->render('article/detail.html.twig', array(
            'article' => $article,
            'create_comment_form' => $form->createView(),
        ));
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

    /**
     * Edit article
     *
     * @Route("/edition/{id}", name="article_edit", requirements={"id": "\d+"})
     *
     * @param Request $request
     * @param int $id
     *
     * @return Response
     */
    public function editAction(Request $request, $id)
    {
        $articleChecker = $this->get('AppBundle\Service\DataChecker\ArticleChecker');
        $article = $articleChecker->checkIfExists($id);
        if (is_null($article)) {
            throw new NotFoundHttpException();
        }

        $formGenerator = $this->get('AppBundle\Service\FormGenerator\ArticleFormGenerator');
        $form = $formGenerator->generateForEdit($article, 'edit_article_form');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articleManager = $this->get('AppBundle\Manager\ArticleManager');
            $articleManager->update($form->getData());

            return $this->redirectToRoute('article_list');
        }

        return $this->render('article/manipulate.html.twig', array(
            'create_article_form' => $form->createView(),
            'action_type' => ManipulationActionType::ACTION_EDIT,
        ));
    }

    /**
     * Delete article
     *
     * @Route("/suppression/{id}", name="article_delete", requirements={"id": "\d+"})
     *
     * @param $id
     *
     * @return Response
     */
    public function deleteAction($id)
    {
        $articleChecker = $this->get('AppBundle\Service\DataChecker\ArticleChecker');
        $article = $articleChecker->checkIfExists($id);
        if (is_null($article)) {
            throw new NotFoundHttpException();
        }

        $articleManager = $this->get('AppBundle\Manager\ArticleManager');
        $articleManager->delete($article);

        return $this->redirectToRoute('article_list');
    }
}