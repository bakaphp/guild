<?php

declare(strict_types=1);

namespace Kanvas\Guild\Peoples\Models;

use Kanvas\Guild\BaseModel;

class PeoplesAddress extends BaseModel
{
    public string $peoples_id;
    public ?string $address = null;
    public ?string $address_2 = null;
    public ?string $city = null;
    public ?string $state = null;
    public ?string $zip = null;
    public int $is_default = 0;
    public ?int $countries_id = null;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('peoples_address');

        $this->belongsTo(
            'peoples_id',
            Peoples::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'people',
            ]
        );
    }
}
