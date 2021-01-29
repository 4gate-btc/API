<?php


namespace App\MessageHandler;


use App\Messenger\MessageRequest;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MessageRequestHandler implements MessageHandlerInterface
{
    public function __invoke(MessageRequest $request)
    {
        dd($request);
    }
}