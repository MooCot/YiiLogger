<?php

namespace app\models;

class DatabaseLog implements LogInterface
{
    public function send(string $message)
    {
        return $message . ' database';
    }
}
