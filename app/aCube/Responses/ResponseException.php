<?php namespace aCube\Responses;

class ResponseException extends \Exception {

    /**
     * @param string $message
     * @return void
     */
    public function __construct($message)
    {
        parent::__construct($message);
    } 

}