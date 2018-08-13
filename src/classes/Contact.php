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
 * @property Group[] $groups
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

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->addChanel($email, Channel::EMAIL);
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->addChanel($phone, Channel::SMS);
    }

    /**
     * @param string|Group $group
     * @return bool
     */
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
