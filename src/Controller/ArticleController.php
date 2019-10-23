<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('a');
    }

    /**
     * @Route("/new/{slug}")
     */
    public function show($slug)
    {
        return new Response(sprintf('Future page to show the arctile: %s', $slug));
    }
}
