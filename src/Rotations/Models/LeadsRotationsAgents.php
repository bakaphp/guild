<?php

declare(strict_types=1);

namespace Kanvas\Guild\Rotations\Models;

use Kanvas\Guild\BaseModel;
use Kanvas\Guild\Leads\Models\Receivers;

class LeadsRotationsAgents extends BaseModel
{
    public int $rotations_id;
    public int $receivers_id;
    public int $companies_id;
    public int $users_id;
    public ?string $phone;
    public float $percent;
    public int $hits;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('leads_rotations_agents');

        $this->belongsTo(
            'rotations_id',
            Rotations::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'rotation',
            ]
        );

        $this->belongsTo(
            'receivers_id',
            Receivers::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'receiver',
            ]
        );
    }
}
