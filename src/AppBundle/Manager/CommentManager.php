<?php
namespace AppBundle\Manager;

use AppBundle\Manager\BaseManager;
use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Article;

/**
 * Class CommentManager. Comment (Commentaire entity) manager
 * @package AppBundle\Manager
 */
class CommentManager extends BaseManager
{
    /**
     * Create an article comment
     *
     * @param Commentaire $comment
     * @param Article $article
     * @param bool $flush
     */
    public function create(Commentaire $comment, Article $article, $flush = true)
    {
        if (is_null($article->getId())) {
            return;
        }
        $comment->setPublishedAt(new \DateTime('now'));
        $comment->setArticle($article);
        $article->addComment($comment);
        $this->em->persist($comment);

        if (true === $flush) {
            $this->flush();
        }

        return;
    }
}