<?php

namespace ESputnicService\classes;

/**
 * Class Channel
 * @package ESputnicService\classes
 *
 * @property string $type
 * @property string $value
 */
class Channel
{
    public $type;
    public $value;

    const EMAIL = 'email';
    const SMS = 'sms';
}