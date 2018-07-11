<?php
/**
 * Created by PhpStorm.
 * User: egretos
 * Date: 26.03.18
 * Time: 9:11
 */

namespace ESputnicService;

use stdClass;

class ESputnicApi
{
    public $ApiUrl = 'https://esputnik.com/api/';
    public $ch;

    public function __construct($user, $password)
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Content-Type: application/json']);
        curl_setopt($this->ch, CURLOPT_USERPWD, $user.':'.$password);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    }
    /**
     * @param $requestString string
     * @param $postFields []
     * @return string
     */
    public function request($requestString, $postFields = false)
    {
        curl_setopt($this->ch, CURLOPT_URL, ($this->ApiUrl . $requestString));

        if ($postFields) {
            curl_setopt($this->ch, CURLOPT_POST, 1);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($postFields));
        } else {
            curl_setopt($this->ch, CURLOPT_POST, 0);
        }

        return curl_exec($this->ch);
    }

    /**
     * @param $email string|array Subscriber Email|Params array
     * @param $name string|null Subscriber Name
     * @param $groups array|null Subscriber groups
     * @param $phone array|null Subscriber phone
     * @return string
     */
    public function subscribe($email, $name = null, $groups = null, $phone = null)
    {
        $requestFields = new stdClass();
        $requestFields->contact = new stdClass();
        if (func_num_args() == 1) {
            $requestFields->contact->firstName = $email['name'];
            $requestFields->contact->channels = [
                [
                    'type' => 'email',
                    'value' => $email['email']
                ]
            ];
            if (isset($email['sms'])) {
                $requestFields->contact->channels[] = [
                    'type' => 'sms',
                    'value' => $email['sms']
                ];
            }

            $requestFields->groups = $email['groups'];

            if (isset($email['formType'])) {
                $requestFields->formType = $email['formType'];
            }
        } else {
            $requestFields->contact->firstName = $name;
            $requestFields->contact->channels = [
                [
                    'type' => 'email',
                    'value' => $email
                ],
                [
                    'type' => 'sms',
                    'value' => $phone
                ],
            ];
            $requestFields->groups = $groups;
        }

        return $this->request('v1/contact/subscribe', $requestFields);
    }

    /**
     * @param ESputnicMessage $message email message instance to be sent
     * @return bool whether the message has been sent successfully
     */
    public function sendMessage(ESputnicMessage $message)
    {
        $requestFields = $this->generate($message);
        $url = 'v1/message/'.$message->getId().'/send';
        return $this->request($url, $requestFields);
    }

    public function generate(ESputnicMessage $message)
    {
        $requestFields = new stdClass();

        if (!$message->validate()) {
            return false;
        }
        $requestFields->recipients  = $message->getTo();
        $requestFields->emails      = $message->getTo();
        $requestFields->subject     = $message->getSubject();
        $requestFields->htmlText    = $message->getHtmlBody();
        $requestFields->plainText   = $message->getTextBoby();
        $requestFields->fromName    = $message->getFrom();
        $requestFields->from        = $message->getFrom();
        $requestFields->allowUnconfirmed = true;
        // TODO add tags, css, rawHtml

        $messageParams = $message->getParams();
        $requestFields->params = [];

        foreach ($messageParams as $key => $value) {
            $requestFields->params[] = [
                'key' => $key,
                'value' => $value,
            ];
        }

        if ($message->getGroup()) {
            $requestFields->groupId = $message->getGroup();
        }

        if ($message->getId()) {
            unset($requestFields->from);
            unset($requestFields->fromName);
        }

        return $requestFields;
    }

    /**
     * @param $messageId string
     * @return string
     */
    public function messageStatus($messageId)
    {
        $url = 'v1/message/email/status?ids=' . $messageId;
        return $this->request($url);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }
}
