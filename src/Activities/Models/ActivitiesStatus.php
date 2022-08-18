<?php

declare(strict_types=1);

namespace Kanvas\Guild\Activities\Models;

use Baka\Database\Behaviors\Uuid;
use Kanvas\Guild\BaseModel;

class ActivitiesStatus extends BaseModel
{
    public string $name;
    public int $is_default;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('activities_status');

        $this->addBehavior(
            new Uuid()
        );
    }
}
