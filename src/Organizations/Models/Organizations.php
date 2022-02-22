<?php

declare(strict_types=1);

namespace Kanvas\Guild\Organizations\Models;

use Baka\Database\Behaviors\Uuid;
use Kanvas\Guild\BaseModel;

class Organizations extends BaseModel
{
    public ?string $uuid = null;
    public int $companies_id;
    public int $users_id;
    public string $name;
    public string $slug;
    public string $address;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('organizations');

        $this->addBehavior(
            new Uuid()
        );
    }
}
