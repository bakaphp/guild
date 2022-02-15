<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Pipelines;

use IntegrationTester;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Kanvas\Guild\Pipelines\Models\PipelinesStages;
use Kanvas\Guild\Pipelines\Pipelines;
use Kanvas\Guild\Tests\Support\Models\Missions;
use Kanvas\Guild\Tests\Support\Models\Users;

class PipelinesStageCest
{
    public ModelsPipelines $pipeline;
    public PipelinesStages $pipelineStage;

    /**
     * Test create a new pipeline
     *
     * @param IntegrationTester $I
     * @before getPipeline
     * @return void
     */
    public function testCreatePipelineStage(IntegrationTester $I) : void
    {
        $name = "First Pipeline Stage";

        $pipelineStage = Pipelines::createStage(
            $this->pipeline,
            $name,
            true,
            14
        );

        $this->pipelineStage = $pipelineStage;

        $I->assertEquals($name, $pipelineStage->name);
    }

    /**
     * Get all pipelines
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAllPipelines(IntegrationTester $I) : void
    {
        $pipelines = Pipelines::getAll(new Users());

        $I->assertTrue(isset($pipelines[0]['id']));
    }

    /**
     * Test get pipelines stages
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetPipelineStage(IntegrationTester $I) : void
    {
        $pipelineStages = Pipelines::getStagesByPipeline($this->pipeline, new Users());

        $I->assertTrue(isset($pipelineStages[0]['id']));

        $pipelinesStages = Pipelines::getAllStages(new Users(), 1);
        $I->assertTrue(isset($pipelinesStages[0]['id']));
    }


    /**
     * Get Pipeline stage by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetPipelineStageById(IntegrationTester $I) : void
    {
        $pipelineStage = Pipelines::getStageById($this->pipelineStage->getId());

        $I->assertEquals($pipelineStage->getId(), $this->pipelineStage->getId());
    }


    /**
     * Update pipeline
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testUpdatePipeline(IntegrationTester $I) : void
    {
        $data = [
            'has_rotting_days' => false,
            'rotting_days' => 12,
            'name' => 'Update stage'
        ];

        $pipeline = Pipelines::updateStage($this->pipelineStage, $data);

        $I->assertEquals($pipeline->name, $data['name']);
    }

    /**
     * Set a pipeline
     *
     * @return void
     */
    private function getPipeline() : void
    {
        $this->pipeline = ModelsPipelines::findFirst();
    }
}
