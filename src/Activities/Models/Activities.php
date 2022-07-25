<?php

declare(strict_types=1);

namespace Kanvas\Guild\Activities\Models;

use Baka\Database\Behaviors\Uuid;
use Kanvas\Guild\BaseModel;
use Phalcon\Utils\Slug;

class Activities extends BaseModel
{
    public ?int $apps_id = null;
    public int $companies_id;
    public int $leads_id;
    public string $uuid;
    public string $title;
    public string $slug;
    public ?string $description = null;
    public string $start_date;
    public string $end_date;
    public int $activity_type_id;
    public int $activities_status_id;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('activities');

        $this->belongsTo(
            'activity_type_id',
            ActivitiesTypes::class,
            'id',
            [
                'alias' => 'type'
            ]
        );

        $this->addBehavior(
            new Uuid()
        );
    }

    /**
     * Before create
     *
     * @return void
     */
    public function beforeCreate() : void
    {
        $this->slug = Slug::generate($this->title);
        parent::beforeCreate();
    }

    /**
     * Before save
     *
     * @return void
     */
    public function beforeSave() : void
    {
        $this->slug = Slug::generate($this->title);
    }
}
