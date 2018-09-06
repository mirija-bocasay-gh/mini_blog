<?php
namespace AppBundle\Service\FormGenerator;

use AppBundle\Service\FormGenerator\FormGenerator;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Symfony\Component\Form\FormInterface;

/**
 * Class ArticleFormGenerator. Article form generator
 * @package AppBundle\Service\FormGenerator
 */
class ArticleFormGenerator extends FormGenerator
{
    const DEFAULT_FORM_CLASS = ArticleType::class;

    /**
     * Generate form for create action
     *
     * @param $formName
     *
     * @return FormInterface
     */
    public function generateForCreate($formName)
    {
        $article = new Article();
        $form = $this->formFactory->createNamed(
            $formName,
            self::DEFAULT_FORM_CLASS,
            $article
        );

        return $form;
    }

    /**
     * Generate form for edit action
     *
     * @param Article $article
     * @param $formName
     *
     * @return FormInterface
     */
    public function generateForEdit(Article $article, $formName)
    {
        $form = $this->formFactory->createNamed(
            $formName,
            self::DEFAULT_FORM_CLASS,
            $article
        );

        return $form;
    }
}