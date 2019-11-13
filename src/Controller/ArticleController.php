<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @var bool
     * Currently unused: just showing
     */
    private $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homepage(ArticleRepository $repository)
    {
//        $articles = $repository->findBy([], ['pulishedAt' => 'DESC']);
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render(
            'article/homepage.html.twig',
            [
                'articles' => $articles,
            ]
        );
    }

    /**
     * @Route("/new/{slug}", name="app_show")
     * @param Article $article
     * @param SlackClient $slack
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Http\Client\Exception
     */
    public function show(Article $article, SlackClient $slack)
    {
        if ($article->getSlug() === 'khaaaaaan') {
            $slack->sendMessage('Khan', 'Ah, Kirk, my old friend...');
        }

        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        return $this->render(
            'article/show.html.twig',
            [
                'article' => $article,
                'comments' => $comments,
            ]
        );
    }

    /**
     * @Route("/new/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     * @param Article $article
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $article->incrementHeartCount();
        $entityManager->flush();

        $logger->info('Article is being hearted');

        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }
}
