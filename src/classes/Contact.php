<?php

namespace ESputnicService\classes;

/**
 * Class Contact
 * @package ESputnicService\classes
 *
 * @property integer $id
 * @property string $contactKey
 * @property string $firstName
 * @property string $lastName
 * @property Channel[] $channels
 */
class Contact
{
    public $id;
    public $contactKey;

    public $firstName;
    public $lastName;

    public $channels = [];
    public $fields = [];
    public $ordersInfo = [];
    public $groups = [];

    public $address;
    public $addressBookID;

    /**
     * @param string $value
     * @param string $type
     */
    public function addChanel($value, $type = Channel::EMAIL)
    {
        $channel = new Channel();
        $channel->value = $value;
        $channel->type = $type;

        $this->channels[] = $channel;
    }

    public function setEmail($email)
    {
        $this->addChanel($email, Channel::EMAIL);
    }

    public function setPhone($phone)
    {
        $this->addChanel($phone, Channel::SMS);
    }

    public function addGroup($group)
    {
        if ($group instanceof Group) {
            $this->groups[] = $group;
            return true;
        }

        if (is_string($group)) {
            $gr = new Group();
            $gr->name = $group;
            $this->addGroup($gr);
            return true;
        }

        return false;
    }
}
