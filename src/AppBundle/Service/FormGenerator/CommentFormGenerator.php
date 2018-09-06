<?php
namespace AppBundle\Service\FormGenerator;

use AppBundle\Service\FormGenerator\FormGenerator;
use AppBundle\Form\CommentType;
use AppBundle\Entity\Commentaire;

/**
 * Class CommentFormGenerator. Comment form generator
 * @package AppBundle\Service\FormGenerator
 */
class CommentFormGenerator extends FormGenerator
{
    const DEFAULT_FORM_CLASS = CommentType::class;

    /**
     * Generate for for create action
     *
     * @param $formName
     * @return \Symfony\Component\Form\FormInterface
     */
    public function generateForCreate($formName)
    {
        $comment = new Commentaire();
        $form = $this->formFactory->createNamed(
            $formName,
            self::DEFAULT_FORM_CLASS,
            $comment
        );

        return $form;
    }
}