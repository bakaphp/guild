<?php

declare(strict_types=1);

namespace Kanvas\Guild\Activities\Models;

use Baka\Database\Behaviors\Uuid;
use Kanvas\Guild\BaseModel;

class ActivitiesTypes extends BaseModel
{
    public int $apps_id;
    public int $companies_id;
    public string $name;
    public ?string $description = null;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('activities_types');

        $this->addBehavior(
            new Uuid()
        );
    }
}
