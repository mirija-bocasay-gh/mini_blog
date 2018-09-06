<?php
namespace AppBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class BaseManager. Base manager
 * @package AppBundle\Manager
 */
class BaseManager
{
    protected $em;

    /**
     * BaseManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * flush on current EntityManager
     */
    public function flush()
    {
        $this->em->flush();
    }
}