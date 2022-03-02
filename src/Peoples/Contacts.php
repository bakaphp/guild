<?php

declare(strict_types=1);

namespace Kanvas\Guild\Peoples;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Peoples\Models\ContactsTypes;
use Kanvas\Guild\Peoples\Models\Peoples;
use Kanvas\Guild\Peoples\Models\PeoplesContacts;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;

class Contacts
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ContactsTypes();
    }

    /**
     * Create a new contact type
     *
     * @param UserInterface $user
     * @param string $name
     * @param string $icon
     * @return ContactsTypes
     */
    public static function createContactType(UserInterface $user, string $name, string $icon = '') : ContactsTypes
    {
        $contactType = new ContactsTypes();
        $contactType->companies_id = $user->currentCompanyId();
        $contactType->users_id = $user->getId();
        $contactType->name = $name;
        $contactType->icon = $icon;
        $contactType->saveOrFail();

        return $contactType;
    }

    /**
     * Create a new contact from people
     *
     * @param Peoples $people
     * @param ContactsTypes $contactType
     * @param string $value
     * @param integer $weight
     * @return PeoplesContacts
     */
    public static function createNewContact(Peoples $people, ContactsTypes $contactType, string $value, int $weight = 0) : PeoplesContacts
    {
        $peopleContact = new PeoplesContacts();
        $peopleContact->contacts_types_id = $contactType->getId();
        $peopleContact->peoples_id = $people->getId();
        $peopleContact->value = $value;
        $peopleContact->weight = $weight;
        $peopleContact->saveOrFail();

        return $peopleContact;
    }
}
