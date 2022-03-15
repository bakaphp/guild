<?php

declare(strict_types=1);

namespace Kanvas\Guild\Deals\Models;

use Baka\Database\Behaviors\Uuid;
use Kanvas\Guild\BaseModel;
use Kanvas\Guild\Leads\Models\Leads;
use Kanvas\Guild\Organizations\Models\Organizations;
use Kanvas\Guild\Pipelines\Models\Stages as PipelinesStages;
use Kanvas\Guild\Rotations\Models\LeadsRotationsAgents;

class Deals extends BaseModel
{
    public string $uuid;
    public int $leads_id;
    public int $users_id;
    public int $companies_id;
    public int $owner_id;
    public int $status_id;
    public int $pipeline_stage_id;
    public int $people_id;
    public int $organization_id;
    public string $title;
    public ?string $description = null;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('deals');

        $this->addBehavior(
            new Uuid()
        );

        $this->hasOne(
            'pipeline_stage_id',
            PipelinesStages::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'pipelineStages',
            ]
        );

        $this->hasOne(
            'leads_id',
            Leads::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'lead',
            ]
        );

        $this->hasOne(
            'organization_id',
            Organizations::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'organization',
            ]
        );

        $this->hasOne(
            'owner_id',
            LeadsRotationsAgents::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'owner',
            ]
        );
    }
}
