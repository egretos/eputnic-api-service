<?php
/**
 * Created by PhpStorm.
 * User: egretos
 * Date: 02.04.18
 * Time: 14:29
 */

namespace ESputnicService;


use yii\mail\BaseMailer;
use yii\mail\MessageInterface;

class ESputnicMailer extends BaseMailer
{
    public $api;

    public function __construct(ESputnicApi $api, array $config = [])
    {
        $this->api = $api;
        parent::__construct($config);
    }


    /**
     * @param null $view
     * @param array $params
     * @return ESputnicMessage|MessageInterface
     */
    public function compose($view = null, array $params = [])
    {
        return new ESputnicMessage();
    }

    /**
     * @param MessageInterface $message email message instance to be sent
     * @return bool whether the message has been sent successfully
     */
    public function send($message)
    {
        return $this->sendMessage($message);
    }

    /**
     * Sends the specified message.
     * This method should be implemented by child classes with the actual email sending logic.
     * @param ESputnicMessage $message the message to be sent
     * @return bool whether the message is sent successfully
     */
    public function sendMessage($message)
    {
        if ($res = $this->api->sendMessage($message)) {
            return $this->api->messageStatus(json_decode($res)->results->requestId);
        } else {
            return false;
        }
    }
}