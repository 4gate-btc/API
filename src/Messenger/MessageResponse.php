<?php


namespace App\Messenger;


use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

class MessageResponse extends Message
{
    public function __construct(string $input, string $clientIp, string $type, string $id, string $output)
    {
        parent::__construct($input, $clientIp, $type);

        $this->id = $id;
        $this->output = $output;
    }

    public function setOutput(string $dataOutput) {
        $this->output = $dataOutput;
    }

    public function getOutput() {
        return $this->output;
    }
}