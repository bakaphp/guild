<?php
namespace Helper\DataBuilder;

use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Kanvas\Guild\Pipelines\Models\Stages;
use Kanvas\Guild\Pipelines\Pipelines as PipelinesMethods;
use Kanvas\Guild\Tests\Support\Models\Missions;
use Kanvas\Guild\Tests\Support\Models\Users;

class Pipelines
{
    /**
     * Create a new Pipeline for testing
     *
     * @return ModelsPipelines
     */
    public static function createPipeline(UserInterface $user) : ModelsPipelines
    {
        $name = "Pipeline No.".rand(1, 100);

        return PipelinesMethods::create($name, new Missions(), $user);
    }

    /**
     * Create a new pipeline Stage for testing
     *
     * @return Stages
     */
    public static function createPipelineStage() : Stages
    {
        $name = "Pipeline Stage No.".rand(1, 100);

        return PipelinesMethods::createStage(
            self::createPipeline(new Users()),
            $name,
            true,
            14
        );
    }
}
