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
use Yii;

class ESputnicMailer extends BaseMailer
{
    public $api;
    private $_message;

    public function __construct(array $config = [])
    {
        $api = new ESputnicApi(
            \Yii::$app->params['esputnic.username'],
            \Yii::$app->params['esputnic.userpass']
        );
        $this->api = $api;
        //parent::__construct($config);
    }


    /**
     * @param null $view
     * @param array $params
     * @return ESputnicMessage|MessageInterface
     */
    public function compose($view = null, array $params = [])
    {
        $message = new ESputnicMessage();
        if ($view === null) {
            return $message;
        }

        if (!array_key_exists('message', $params)) {
            $params['message'] = $message;
        }

        $this->_message = $message;

        if (is_array($view)) {
            if (isset($view['html'])) {
                $html = $this->render($view['html'], $params, $this->htmlLayout);
            }
            if (isset($view['text'])) {
                $text = $this->render($view['text'], $params, $this->textLayout);
            }
        } else {
            $html = $this->render($view, $params, $this->htmlLayout);
        }

        $this->_message = null;

        if (isset($html)) {
            $message->setBody($html);
        }
        if (isset($text)) {
            $message->setTextBody($text);
        } elseif (isset($html)) {
            if (preg_match('~<body[^>]*>(.*?)</body>~is', $html, $match)) {
                $html = $match[1];
            }
            // remove style and script
            $html = preg_replace('~<((style|script))[^>]*>(.*?)</\1>~is', '', $html);
            // strip all HTML tags and decoded HTML entities
            $text = html_entity_decode(
                strip_tags($html),
                ENT_QUOTES | ENT_HTML5,
                Yii::$app ? Yii::$app->charset : 'UTF-8'
            );
            // improve whitespace
            $text = preg_replace("~^[ \t]+~m", '', trim($text));
            $text = preg_replace('~\R\R+~mu', "\n\n", $text);
            $message->setTextBody($text);
        }

        return $message;
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