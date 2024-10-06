<?php

namespace Valres\AtomSanctions\libs\AtomDiscordAPI\task;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class DiscordWebhookSendTask extends AsyncTask
{
    private string $url;
    private string $message;

    public function __construct(string $url, string $message) {
        $this->url = $url;
        $this->message = $message;
    }

    public function onRun(): void {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->message);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        $this->setResult([curl_exec($ch), curl_getinfo($ch, CURLINFO_RESPONSE_CODE)]);
        curl_close($ch);
    }

    public function onCompletion(): void {
        $response = $this->getResult();
        if (!in_array($response[1], [200, 204])) {
            Server::getInstance()->getLogger()->error("[WEBHOOK] Got error ({$response[1]}): " . $response[0]);
        }
    }
}

