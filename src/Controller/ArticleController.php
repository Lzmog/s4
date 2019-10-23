<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render(
            'article/homepage.html.twig'
        );
    }

    /**
     * @Route("/new/{slug}", name="app_show")
     */
    public function show($slug)
    {
        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        return $this->render(
            'article/show.html.twig',
            [
                'title' => ucwords(str_replace('-', ' ', $slug)),
                'slug' => $slug,
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

        return new JsonResponse(['hearts' => rand(5,100)]);
    }
}
