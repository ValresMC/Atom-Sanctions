<?php

declare(strict_types=1);

namespace Valres\AtomSanctions\libs\AtomDiscordAPI;

use Valres\AtomSanctions\libs\AtomDiscordAPI\task\DiscordWebhookSendTask;
use pocketmine\Server;

class Webhook
{
    protected string $url;

    public function __construct(string $url) {
        $this->url = $url;
    }

    public function isValid(): bool {
        return filter_var($this->url, FILTER_VALIDATE_URL) !== false;
    }

    public function send(Message $message): void {
        Server::getInstance()->getAsyncPool()->submitTask(new DiscordWebhookSendTask($this->getURL(), json_encode($message)));
    }

    public function getURL(): string {
        return $this->url;
    }
}