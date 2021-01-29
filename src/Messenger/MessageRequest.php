<?php


namespace App\Messenger;


class MessageRequest extends Message
{
    public function __construct(string $input, string $clientIp, string $type, string $idPrefix = '', string $id = null)
    {
        parent::__construct($input, $clientIp, $type,$idPrefix);

        if($id)
            $this->id = $id;
    }

    public function createResponse(): MessageResponse {
        return new MessageResponse($this->input,$this->clientIp,$this->type,$this->id,json_encode([]));
    }
}