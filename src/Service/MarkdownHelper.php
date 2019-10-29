<?php

declare(strict_types=1);

namespace App\Service;

use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{
    /**
     * @var MarkdownInterface
     */
    private $markdown;

    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(MarkdownInterface $markdown, AdapterInterface $cache, LoggerInterface $markdownLogger)
    {
        $this->markdown = $markdown;
        $this->cache = $cache;
        $this->logger = $markdownLogger;
    }

    /**
     * @param string $source
     * @return string
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function parse(string $source): string
    {
        if (stripos($source, 'bacon')) {
            $this->logger->info('they are talking about bacon');
        }

        $item = $this->cache->getItem('markdown' . md5($source));
        if (false === $item->isHit()) {
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }

        return $item->get();
    }
}
