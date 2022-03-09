<?php
namespace Helper;

use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Kanvas\Guild\Pipelines\Models\Stages;
use Kanvas\Guild\Pipelines\Pipelines;
use Kanvas\Guild\Tests\Support\Models\Missions;

class DataBuilder
{
    public UserInterface $user;

    /**
     * Set user interface to use methods
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Create a new Pipeline for testing
     *
     * @return ModelsPipelines
     */
    public function createPipeline() : ModelsPipelines
    {
        $name = "Pipeline No.".rand(1, 100);

        return Pipelines::create($name, new Missions(), $this->user);
    }

    /**
     * Create a new pipeline Stage for testing
     *
     * @return Stages
     */
    public function createPipelineStage() : Stages
    {
        $name = "Pipeline Stage No.".rand(1, 100);

        return Pipelines::createStage(
            $this->createPipeline(),
            $name,
            true,
            14
        );
    }
}
