<?php
namespace app\models;

class LogSender implements LoggerInterface
{
    private $sender;

    public function send($message)
    {
        $logger = LoggerFactory::createLogger($this->getType());
        return $logger->send($message);
    }
    public function sendByLogger(string $message, string $loggerType)
    {
        $logger = LoggerFactory::createLogger($loggerType);
        return $logger->send($message);
    }
    public function getType(): string
    {
        return (isset($this->sender)) ? $this->sender : \Yii::$app->params['type'];
    }
    public function setType(string $type): void
    {
        (isset($type)) ? $this->sender = $type : \Yii::$app->params['type'];
    }
}
