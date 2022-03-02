<?php

declare(strict_types=1);

namespace Kanvas\Guild\Pipelines\Models;

use Kanvas\Guild\BaseModel;
use Phalcon\Utils\Slug;

class Pipelines extends BaseModel
{
    public string $entity_namespace;
    public int $users_id;
    public string $name;
    public string $slug;
    public int $is_default = 0;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('pipelines');

        $this->hasMany(
            'id',
            Stages::class,
            'pipelines_id',
            [
                'reusable' => true,
                'alias' => 'stages',
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
