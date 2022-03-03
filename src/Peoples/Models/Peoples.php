<?php

declare(strict_types=1);

namespace Kanvas\Guild\Peoples\Models;

use Baka\Database\Behaviors\Uuid;
use Kanvas\Guild\BaseModel;
use Kanvas\Guild\Organizations\Models\Organizations;
use Kanvas\Guild\Organizations\Models\OrganizationsPeoples;

class Peoples extends BaseModel
{
    public string $uuid;
    public int $companies_id;
    public int $users_id;
    public string $name;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('peoples');

        $this->addBehavior(
            new Uuid()
        );

        $this->hasMany(
            'id',
            PeoplesAddress::class,
            'peoples_id',
            [
                'reusable' => true,
                'alias' => 'address',
            ]
        );

        $this->hasMany(
            'id',
            PeoplesContacts::class,
            'peoples_id',
            [
                'reusable' => true,
                'alias' => 'contacts',
            ]
        );

        $this->hasManyToMany(
            'id',
            OrganizationsPeoples::class,
            'peoples_id',
            'organizations_id',
            Organizations::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'organizations',
            ]
        );
    }
}
