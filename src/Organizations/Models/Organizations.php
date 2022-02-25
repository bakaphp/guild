<?php

declare(strict_types=1);

namespace Kanvas\Guild\Organizations\Models;

use Baka\Database\Behaviors\Uuid;
use Kanvas\Guild\BaseModel;
use Phalcon\Utils\Slug;

class Organizations extends BaseModel
{
    public string $uuid;
    public int $companies_id;
    public int $users_id;
    public string $name;
    public string $slug;
    public string $address;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('organizations');

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
