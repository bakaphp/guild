<?php

declare(strict_types=1);

namespace Kanvas\Guild\Peoples\Models;

use Kanvas\Guild\BaseModel;

class PeoplesContacts extends BaseModel
{
    public int $contacts_types_id;
    public int $peoples_id;
    public string $value;
    public int $weight;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('peoples_contacts');

        $this->belongsTo(
            'peoples_id',
            Peoples::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'people',
            ]
        );

        $this->hasOne(
            'id',
            PeoplesAddress::class,
            'peoples_id',
            [
                'reusable' => true,
                'alias' => 'address',
            ]
        );
    }
}
