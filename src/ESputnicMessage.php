<?php
/**
 * Created by PhpStorm.
 * User: egretos
 * Date: 02.04.18
 * Time: 15:03
 */

namespace ESputnicService;


use yii\mail\BaseMessage;

class ESputnicMessage extends BaseMessage
{

    private $cc = false;
    private $html = false;
    private $to = false;
    private $subject = false;
    private $text = false;
    private $id = false;
    private $params = false;
    private $from = false;
    private $group = false;

    /**
     * @param $id string
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $params array
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return bool|array
     */
    public function getParams()
    {
        return $this->params;
    }

    public function setReplyTo($replyTo)
    {
        // TODO: Implement setReplyTo() method.
    }

    public function getReplyTo()
    {
        // TODO: Implement getReplyTo() method.
    }

    public function embedContent($content, array $options = [])
    {
        // TODO: Implement embedContent() method.
    }

    /**
     * @return string
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @param array|string $cc
     * @return $this|void
     */
    public function setCc($cc)
    {
        $this->cc = $cc;
    }

    /**
     * @param $group string
     * @return $this
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return$this;
    }

    /**
     * return bool|string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Sets the message sender.
     * @param string|array $from sender email address.
     * You may pass an array of addresses if this message is from multiple people.
     * You may also specify sender name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Returns the message sender.
     * @return string|array the sender
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param array|string $to
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return array|bool|string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Sets message HTML content.
     * @param string $html message HTML content.
     * @return $this self reference.
     */
    public function setHtmlBody($html)
    {
        $this->html = $html;
        return $this;
    }

    /**
     * @return string|bool
     */
    public function getHtmlBody()
    {
        return $this->html;
    }

    public function getCharset()
    {
        // TODO: Implement getCharset() method.
    }

    public function attach($fileName, array $options = [])
    {
        // TODO: Implement attach() method.
    }

    public function attachContent($content, array $options = [])
    {
        // TODO: Implement attachContent() method.
    }

    public function embed($fileName, array $options = [])
    {
        // TODO: Implement embed() method.
    }

    public function setBcc($bcc)
    {
        // TODO: Implement setBcc() method.
    }

    public function getBcc()
    {
        // TODO: Implement getBcc() method.
    }

    /**
     * Sets the message subject.
     * @param string $subject message subject
     * @return $this self reference.
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Returns the message subject.
     * @return string|false the message subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets message plain text content.
     * @param string $text message plain text content.
     * @return $this self reference.
     */
    public function setTextBody($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getTextBoby()
    {
        return $this->text;
    }

    public function setCharset($charset)
    {
        // TODO: Implement setCharset() method.
    }

    public function toString()
    {
        // TODO: Implement toString() method.
    }

    /**
     * @return bool
     */
    public function validate()
    {
        return (
            $this->getTo() ||
            $this->getFrom() ||
            $this->getSubject() ||
            $this->getHtmlBody() ||
            $this->getTextBoby()
        );
    }
}