<?php

declare(strict_types=1);

namespace Kanvas\Guild\Pipelines;

use Kanvas\Guild\BaseModel;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Phalcon\Di;
use Phalcon\Utils\Slug;

class Pipelines
{
    public static function create(string $name, BaseModel $entity)
    {
        $pipeline = new ModelsPipelines();
        $pipeline->entity_namespace = get_class($entity);
        $pipeline->name = $name;
        $pipeline->users_id = Di::getDefault()->get('userData')->getId();
        $pipeline->slug = Slug::generate($name);
        $pipeline->saveOrFail();

        return $pipeline;
    }
}
