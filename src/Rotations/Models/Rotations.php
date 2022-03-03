<?php

declare(strict_types=1);

namespace Kanvas\Guild\Rotations\Models;

use Kanvas\Guild\BaseModel;
use Phalcon\Utils\Slug;

class Rotations extends BaseModel
{
    public int $companies_id;
    public int $users_id;
    public string $name;
    public string $slug;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('rotations');

        $this->hasMany(
            'id',
            LeadsRotationsAgents::class,
            'rotations_id',
            [
                'reusable' => true,
                'alias' => 'rotationAgents',
            ]
        );
    }

        /**
     * Before create
     *
     * @return void
     */
    public function beforeCreate() : void
    {
        $this->slug = Slug::generate($this->name);
        parent::beforeCreate();
    }

    /**
     * Before save
     *
     * @return void
     */
    public function beforeSave() : void
    {
        $this->slug = Slug::generate($this->name);
    }
}
