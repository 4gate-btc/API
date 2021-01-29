<?php


namespace App\Messenger;


abstract class Message
{
    /**
     * Data from the request formatted in json
     * @var string
     */
    protected string $input;

    /**
     * Data from the response formatted in json
     * @var string
     */
    protected string $output;

    /**
     * IP of the client that made the request in order to prevent stealing if someone has the id of the request
     * @var string
     */
    protected string $clientIp;

    /**
     * unique id of the message in order to be able to get response from it later
     * @var string
     */
    protected string $id;

    /**
     * Type of the message in order to be able to route the message to the correct handler
     * @var string
     */
    protected string $type;

    /**
     * Message constructor.
     * @param string $dataInput
     * @param string $clientIp ip of the client that made the request from the api in order to restrain access of the output and input
     * @param string $type type of message sent in order to route to the correct handler
     * @param string $idPrefix prefix of the id that is being generated
     */
    public function __construct(string $input, string $clientIp, string $type, string $idPrefix = '')
    {
        $this->id=uniqid($idPrefix.'_');
        $this->input = $input;
        $this->clientIp = $clientIp;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function getInput(): string
    {
        return $this->input;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getClientIp(): string
    {
        return $this->clientIp;
    }
}