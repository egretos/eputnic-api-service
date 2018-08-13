<?php

namespace ESputnicService\classes\forms;

use ESputnicService\classes\Contact;

class ContactBulkUpdateForm
{
    public $contacts = [];
    public $dedupeOn;
    public $fieldId;
    public $contactFields = [];
    public $customFieldsIds = [];
    public $groupNames = [];
    public $groupNamesExclude = [];
    public $restoreDeleted = false;
    public $eventKeyForNewContacts = 'updateFromAPI';

    /**
     * @param Contact $contact
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
    }

    /**
     * @param string $group
     */
    public function addGroup($group)
    {
        $this->groupNames[] = $group;
    }

    public function setFormType($formType)
    {
        $this->eventKeyForNewContacts = $formType;
    }
}
