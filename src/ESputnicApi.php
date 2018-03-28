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

        if (isset($postFields)) {
            curl_setopt($this->ch, CURLOPT_POST, 1);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($postFields));
        }

        return curl_exec($this->ch);
    }

    /**
     * @param $email string|array Subscriber Email|Params array
     * @param $name string|null Subscriber Name
     * @param $groups array|null Subscriber groups
     * @return string
     */
    public function subscribe($email, $name = null, $groups = null)
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
            $requestFields->groups = $email['groups'];
        } else {
            $requestFields->contact->firstName = $name;
            $requestFields->contact->channels = [
                [
                    'type' => 'email',
                    'value' => $email
                ]
            ];
            $requestFields->groups = $groups;
        }

        return $this->request('v1/contact/subscribe', $requestFields);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }
}
