<?php

declare(strict_types=1);

namespace Kanvas\Guild\Peoples\Models;

use Kanvas\Guild\BaseModel;

class ContactsTypes extends BaseModel
{
    public int $companies_id;
    public int $users_id;
    public string $name;
    public string $icon;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('contacts_types');

        $this->hasMany(
            'id',
            PeoplesContacts::class,
            'contacts_types_id',
            [
                'reusable' => true,
                'alias' => 'contacts',
            ]
        );
    }
}
