<?php

declare(strict_types=1);

namespace Kanvas\Guild\Pipelines\Models;

use Kanvas\Guild\BaseModel;

class PipelinesStages extends BaseModel
{
    public string $entity_namespace;
    public int $users_id;
    public string $name;
    public string $slug;
    public int $is_default = 0;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('pipelines_stages');
    }
}
