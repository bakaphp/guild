<?php

declare(strict_types=1);

namespace Kanvas\Guild\Organizations\Models;

use Kanvas\Guild\BaseModel;

class OrganizationsPeoples extends BaseModel
{
    public int $organizations_id;
    public int $peoples_id;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('organizations_peoples');
    }
}
