<?php

declare(strict_types=1);

namespace App\Service;

use Michelf\MarkdownInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{
    /** @var MarkdownInterface */
    private $markdown;

    /** @var AdapterInterface */
    private $cache;

    public function __construct(MarkdownInterface $markdown, AdapterInterface $cache)
    {
        $this->markdown = $markdown;
        $this->cache = $cache;
    }

    /**
     * @param string $source
     * @return string
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function parse(string $source): string
    {
        $item = $this->cache->getItem('markdown' . md5($source));
        if (false === $item->isHit()) {
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }

        return $item->get();
    }
}
