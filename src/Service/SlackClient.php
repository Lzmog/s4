<?php

declare(strict_types=1);

namespace App\Service;

use App\Helper\LoggerTrait;
use Nexy\Slack\Client;

class SlackClient
{
    use LoggerTrait;

    /**
     * @var Client
     */
    private $slack;

    public function __construct(Client $slack)
    {
        $this->slack = $slack;
    }

    /**
     * @param string $from
     * @param string $slackMessage
     * @throws \Http\Client\Exception
     */
    public function sendMessage(string $from, string $slackMessage): void
    {
        $this->logInfo('Beaming a message to Slack!', ['message' => $slackMessage]);

        $slackMessage = $this->slack->createMessage()
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($slackMessage);
        $this->slack->sendMessage($slackMessage);
    }
}
