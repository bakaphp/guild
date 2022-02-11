<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Support\Models;

use Kanvas\Guild\BaseModel;

class Missions extends BaseModel
{
    public function getId() : int
    {
        return $this->id ?? 1;
    }
}
