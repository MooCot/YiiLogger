<?php

namespace app\models;

class FileLog implements LogInterface
{
    public function send(string $message)
    {
        return $message . ' File';
    }

}
