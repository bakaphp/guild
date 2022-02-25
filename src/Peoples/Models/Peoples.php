<?php

declare(strict_types=1);

namespace Kanvas\Guild\Peoples\Models;

use Baka\Database\Behaviors\Uuid;
use Kanvas\Guild\BaseModel;

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
    }
}
