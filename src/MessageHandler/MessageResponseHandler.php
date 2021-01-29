<?php


namespace App\MessageHandler;


use App\Messenger\MessageResponse;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MessageResponseHandler implements MessageHandlerInterface
{
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function __invoke(MessageResponse $response)
    {
        $id = $response->getId();

        $this->cache->delete($id);
        $this->cache->get($id,function() use($response) { return $response; });
    }
}