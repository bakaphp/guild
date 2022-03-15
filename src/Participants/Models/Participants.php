<?php

declare(strict_types=1);

namespace Kanvas\Guild\Participants\Models;

use Kanvas\Guild\BaseModel;
use Kanvas\Guild\Leads\Models\Leads;
use Kanvas\Guild\Peoples\Models\Peoples;

class Participants extends BaseModel
{
    public int $leads_id;
    public int $peoples_id;
    public int $participants_types_id;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('leads_participants');

        $this->hasOne(
            'peoples_id',
            Peoples::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'lead',
            ]
        );

        $this->belongsTo(
            'leads_id',
            Leads::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'lead',
            ]
        );

        $this->hasOne(
            'participants_types_id',
            Leads::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'lead',
            ]
        );
    }
}
