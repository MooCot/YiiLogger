<?php

namespace app\models;

interface LogInterface
{
    /**
    *Sends message to current logger.
    *
    *@param string $message
    *
    *@return void
    */
    public function send(string $message);
}
