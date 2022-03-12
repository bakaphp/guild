<?php

declare(strict_types=1);

namespace Kanvas\Guild\Leads\Models;

use Kanvas\Guild\BaseModel;

class Status extends BaseModel
{
    public string $name;
    public int $is_default = 0;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('leads_status');

        $this->hasMany(
            'leads_status_id',
            Leads::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'leads',
            ]
        );
    }
}
