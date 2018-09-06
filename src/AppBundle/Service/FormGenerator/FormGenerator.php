<?php
namespace AppBundle\Service\FormGenerator;

use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class FormGenerator. Form generator service
 * @package AppBundle\Service\FormGenerator
 */
class FormGenerator
{
    protected $formFactory;

    /**
     * FormGenerator constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }
}