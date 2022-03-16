<?php

declare(strict_types=1);

namespace Kanvas\Guild\Participants\Models;

use Kanvas\Guild\BaseModel;

class Types extends BaseModel
{
    public ?int $apps_id = null;
    public int $companies_id;
    public string $name;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('leads_participants_types');

        $this->hasMany(
            'id',
            Participants::class,
            'participants_types_id',
            [
                'reusable' => true,
                'alias' => 'participants',
            ]
        );
    }
}
