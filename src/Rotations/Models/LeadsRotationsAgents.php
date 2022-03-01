<?php

declare(strict_types=1);

namespace Kanvas\Guild\Rotations\Models;

use Kanvas\Guild\BaseModel;

class LeadsRotationsAgents extends BaseModel
{
    public int $rotations_id;
    public int $companies_id;
    public int $users_id;
    public ?string $phone;
    public float $percent;
    public int $hits;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('leads_rotations_agents');
    }
}
