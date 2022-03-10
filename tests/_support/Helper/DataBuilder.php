<?php
namespace Helper;

use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Leads\Models\Receivers as ModelsReceivers;
use Kanvas\Guild\Leads\Receivers;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Kanvas\Guild\Pipelines\Models\Stages;
use Kanvas\Guild\Pipelines\Pipelines;
use Kanvas\Guild\Rotations\Models\Rotations as ModelsRotations;
use Kanvas\Guild\Rotations\Rotations;
use Kanvas\Guild\Tests\Support\Models\Missions;
use Kanvas\Guild\Tests\Support\Models\Users;

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

    /**
     * Create a new receiver for testing
     *
     * @return ModelsReceivers
     */
    public function createReceiver() : ModelsReceivers
    {
        $name = "Receiver No.".rand(1, 100);

        return Receivers::create(new Users(), $name, $this->createRotation(), 'Walkin');
    }

    /**
     * Create a new Rotation for testing
     *
     * @return ModelsRotations
     */
    public function createRotation() : ModelsRotations
    {
        $name = "Rotation No.".rand(1, 100);
        return Rotations::create($name, new Users());
    }
}
