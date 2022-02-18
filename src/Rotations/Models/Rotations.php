<?php

declare(strict_types=1);

namespace Kanvas\Guild\Rotations\Models;

use Kanvas\Guild\BaseModel;

class Rotations extends BaseModel
{
    public int $companies_id;
    public int $users_id;
    public string $name;
    public string $slug;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('rotations');
    }
}
