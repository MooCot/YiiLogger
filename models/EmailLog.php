<?php

namespace app\models;

class EmailLog implements LogInterface
{
    public function send(string $message)
    {
        return $message . ' Email ' . \Yii::$app->params['adminEmail'];
    }
}
