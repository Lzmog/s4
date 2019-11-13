<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
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
    public function homepage(EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(Article::class);
//        $articles = $repository->findBy([], ['pulishedAt' => 'DESC']);
        $articles = $repository->findBy([], ['pulishedAt' => 'DESC']);

        return $this->render(
            'article/homepage.html.twig',
            [
                'articles' => $articles,
            ]
        );
    }

    /**
     * @Route("/new/{slug}", name="app_show")
     * @param $slug
     * @param SlackClient $slack
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Http\Client\Exception
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function show($slug, SlackClient $slack, EntityManagerInterface $entityManager)
    {
        if ($slug === 'khaaaaaan') {
            $slack->sendMessage('Khan', 'Ah, Kirk, my old friend...');
        }

        $repository = $entityManager->getRepository(Article::class);

        /** @var Article $article */
        $article = $repository->findOneBy(['slug' => $slug]);

        if (false === $article) {
            throw $this->createNotFoundException(sprintf('No article for slug %s', $slug));
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
     * @param $slug
     * @param LoggerInterface $logger
     * @return JsonResponse
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        $logger->info('Article is being hearted');

        return new JsonResponse(['hearts' => rand(5, 100)]);
    }
}
