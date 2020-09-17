<?php

use App\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require 'vendor/autoload.php';

$loop   = React\EventLoop\Factory::create();
$pusher = new Chat();



$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    9191
);

$server->run();