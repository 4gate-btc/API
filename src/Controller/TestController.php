<?php


namespace App\Controller;


use App\Messenger\MessageRequest;
use App\Messenger\MessageResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class TestController extends AbstractController
{
    #[Route("/register", methods: ['POST'], condition: "request.headers.get('Content-Type') == 'application/json'")]
    public function register(CacheInterface $cache, Request $request) {
        /** @var RedisAdapter $cache */
        if(!json_decode($request->getContent())) {
            throw new JsonException();
        }
        $messageRequest = new MessageRequest(
            $request->getContent(),
            $request->getClientIp(),
            'authentication_user_register',
            'registration'
        );

        $id = $messageRequest->getId();
        $this->dispatchMessage($messageRequest);

        $start = time();
        $response = null;
        do {
            usleep(200000);
            if($cache->hasItem($id)) {
                /** @var CacheItem $message */
                $message = $cache->getItem($id);
                $response = $message->get()->getOutput();
            }
        } while($response == null and time() - $start < 5);

        if($response == null) {
            return new JsonResponse(['request_id'=>$id,'message'=>'Your request is actually in queu, you can fetch the result once done using the request_id on route /request/{id}']);
        }

        return new JsonResponse(json_decode($response,true));
    }
}