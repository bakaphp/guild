<?php

declare(strict_types=1);

namespace Kanvas\Guild\Pipelines;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Kanvas\Guild\Pipelines\Models\Stages;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Utils\Slug;

class Pipelines
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ModelsPipelines();
    }

    /**
     * Create a new pipeline based on name and entity
     *
     * @param string $name
     * @param ModelInterface $entity
     * @return ModelsPipelines
     */
    public static function create(string $name, ModelInterface $entity, UserInterface $user) : ModelsPipelines
    {
        $pipeline = new ModelsPipelines();
        $pipeline->entity_namespace = get_class($entity);
        $pipeline->name = $name;
        $pipeline->users_id = $user->getId();
        $pipeline->companies_id = $user->currentCompanyId();
        $pipeline->saveOrFail();

        return $pipeline;
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

    /**
     * Create a new pipeline stage
     *
     * @param ModelsPipelines $pipeline
     * @param string $name
     * @param boolean $hasRotting
     * @param integer $rottingDays
     * @return Stages
     */
    public static function createStage(ModelsPipelines $pipeline, string $name, bool $hasRotting = false, int $rottingDays = 0) : Stages
    {
        $pipelineStage = new Stages();
        $pipelineStage->name = $name;
        $pipelineStage->pipelines_id = $pipeline->getId();
        $pipelineStage->has_rotting_days = $hasRotting;
        $pipelineStage->rotting_days = $rottingDays;
        $pipelineStage->saveOrFail();
        
        return $pipelineStage;
    }

    /**
     * Update a pipeline stage
     *
     * @param Stages $stage
     * @param array $data
     * @return Stages
     */
    public static function updateStage(Stages $stage, array $data) : Stages
    {
        $updateFields = [
            'name',
            'title',
            'has_rotting_days',
            'rotting_days',
            'weight'
        ];

        $stage->saveOrFail($data, $updateFields);

        return $stage;
    }


    /**
     * Get Pipeline Stage by id
     *
     * @param UserInterface $user
     * @param integer $id
     * @return Stages
     */
    public static function getStageById(int $id) : Stages
    {
        return Stages::findFirstOrFail(
            [
                'conditions' => 'id = :id: AND is_deleted = 0',
                'bind' => [
                    'id' => $id,
                ]
            ]
        );
    }


    /**
     * Get all the stages from a pipeline
     *
     * @param ModelsPipelines $pipeline
     * @param integer $page
     * @param integer $limit
     * @return ResultsetInterface
     */
    public static function getStagesByPipeline(ModelsPipelines $pipeline, int $page = 1, int $limit = 10) : ResultsetInterface
    {
        $offset = ($page - 1) * $limit;

        $pipelines = Stages::find([
            'conditions' => 'pipelines_id = :pipelines_id: AND is_deleted = 0',
            'bind' => [
                'pipelines_id' => $pipeline->getId()
            ],
            'limit' => $limit,
            'offset' => $offset
        ]);

        return $pipelines;
    }
}
