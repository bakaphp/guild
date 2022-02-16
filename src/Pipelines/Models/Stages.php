<?php

declare(strict_types=1);

namespace Kanvas\Guild\Pipelines\Models;

use Kanvas\Guild\BaseModel;

class Stages extends BaseModel
{
    public string $name;
    public int $pipelines_id;
    public bool $has_rotting_days;
    public int $rotting_days = 0;
    public int $weight = 0;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('pipelines_stages');
    }
}
