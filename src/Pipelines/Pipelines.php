<?php

declare(strict_types=1);

namespace Kanvas\Guild\Pipelines;

use Baka\Contracts\Auth\UserInterface;
use Kanvas\Guild\BaseModel;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Phalcon\Di;
use Phalcon\Utils\Slug;

class Pipelines
{
    /**
     * Create a new pipeline based on name and entity
     *
     * @param string $name
     * @param BaseModel $entity
     * @return ModelsPipelines
     */
    public static function create(string $name, BaseModel $entity, UserInterface $user, int $companyId) : ModelsPipelines
    {
        $pipeline = new ModelsPipelines();
        $pipeline->entity_namespace = get_class($entity);
        $pipeline->name = $name;
        $pipeline->users_id = $user->getId();
        $pipeline->companies_id = $companyId;
        $pipeline->slug = Slug::generate($name);
        $pipeline->saveOrFail();

        return $pipeline;
    }

    /**
     * Get all pipelines associated to a company
     *
     * @param integer $page
     * @param integer $limit
     * @return array
     */
    public static function getAll(int $companyId, $page = 1, $limit = 10) : array
    {
        $offset = ($page - 1) * $limit;

        $pipelines = ModelsPipelines::find([
            'conditions' => 'companies_id = :company_id: AND is_deleted = 0',
            'bind' => [
                'company_id' => $companyId
            ],
            'limit' => $limit,
            'offset' => $offset
        ]);

        return $pipelines->toArray();
    }


    /**
     * Get a pipeline by its id
     *
     * @param integer $id
     * @return ModelsPipelines
     */
    public static function getById(int $id) : ModelsPipelines
    {
        return ModelsPipelines::findFirstOrFail(
            [
                'conditions' => 'id = :id: AND companies_id = :companies_id: AND is_deleted = 0',
                'bind' => [
                    'id' => $id,
                    'companies_id' => Di::getDefault()->get('userData')->companies_id,
                ]
            ]
        );
    }


    /**
     * Update pipeline
     *
     * @param ModelsPipelines $pipeline
     * @param string $name
     * @return ModelsPipelines
     */
    public static function update(ModelsPipelines $pipeline, string $name) : ModelsPipelines
    {
        $pipeline->name = $name;
        $pipeline->saveOrFail();

        return $pipeline;
    }
}
