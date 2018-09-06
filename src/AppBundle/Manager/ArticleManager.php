<?php
namespace AppBundle\Manager;

use AppBundle\Manager\BaseManager;
use AppBundle\Entity\Article;

/**
 * Class ArticleManager. Article manager.
 * @package AppBundle\Manager
 */
class ArticleManager extends BaseManager
{
    /**
     * Create new article
     *
     * @param Article $article
     * @param bool $flush
     */
    public function create(Article $article, $flush = true)
    {
        $this->em->persist($article);

        if (true === $flush) {
            $this->flush();
        }

        return;
    }

    /**
     * Update existing article
     *
     * @param Article $article
     * @param bool $flush
     */
    public function update(Article $article, $flush = true)
    {
        if (true === $flush) {
            $this->flush();
        }

        return;
    }

    /**
     * Delete existing article
     *
     * @param Article $article
     * @param bool $flush
     */
    public function delete(Article $article, $flush = true)
    {
        $this->em->remove($article);

        if (true === $flush) {
            $this->flush();
        }

        return;
    }
}