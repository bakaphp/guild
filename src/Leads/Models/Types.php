<?php

declare(strict_types=1);

namespace Kanvas\Guild\Leads\Models;

use Kanvas\Guild\BaseModel;

class Types extends BaseModel
{
    public ?int $apps_id = 0;
    public int $companies_id;
    public string $name;
    public ?string $description = null;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('leads_types');

        $this->hasMany(
            'leads_types_id',
            Leads::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'leads',
            ]
        );
    }
}
