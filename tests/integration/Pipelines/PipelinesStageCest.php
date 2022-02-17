<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Pipelines;

use IntegrationTester;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Kanvas\Guild\Pipelines\Models\Stages;
use Kanvas\Guild\Pipelines\Pipelines;

class PipelinesStageCest
{
    public ModelsPipelines $pipeline;
    public Stages $pipelineStage;

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
     * Get pipeline stage by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetStageById(IntegrationTester $I) : void
    {
        $pipelineStage = Pipelines::getStageById($this->pipelineStage->getId());
        
        $I->assertEquals($pipelineStage->getId(), $this->pipelineStage->getId());
    }

    /**
     * Test get pipelines stages by pipeline
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetPipelineStageByPipeline(IntegrationTester $I) : void
    {
        $pipelineStages = Pipelines::getStagesByPipeline($this->pipeline)->toArray();

        $I->assertTrue(isset($pipelineStages[0]['id']));
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
    public function testUpdatePipelineStage(IntegrationTester $I) : void
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
