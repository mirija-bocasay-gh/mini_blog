<?php
namespace AppBundle\Service\DataChecker;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Article;

/**
 * Class ArticleChecker. Article data checker
 * @package AppBundle\Service\DataChecker
 */
class ArticleChecker
{
    private $em;

    /**
     * ArticleChecker constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Check if article exists by id
     * Return article object if exists
     * Return null if not
     *
     * @param $articleId
     *
     * @return Article|null
     */
    public function checkIfExists($articleId)
    {
        $article = $this->em->getRepository('AppBundle\Entity\Article')->findOneById($articleId);

        return $article;
    }
}