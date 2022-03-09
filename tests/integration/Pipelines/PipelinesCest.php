<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Pipelines;

use IntegrationTester;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Kanvas\Guild\Pipelines\Pipelines;
use Kanvas\Guild\Tests\Support\BaseIntegration;
use Kanvas\Guild\Tests\Support\Models\Missions;
use Kanvas\Guild\Tests\Support\Models\Users;

class PipelinesCest extends BaseIntegration
{
    public ModelsPipelines $pipeline;

    /**
     * Test create a new pipeline
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreatePipeline(IntegrationTester $I) : void
    {
        $name = "Thinking";

        $pipeline = Pipelines::create($name, new Missions(), new Users());

        $this->pipeline = $pipeline;

        $I->assertEquals($name, $pipeline->name);
    }

    /**
     * Get all pipelines
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAllPipelines(IntegrationTester $I) : void
    {
        $this->dataBuilder->createPipeline();

        $pipelines = Pipelines::getAll(new Users())->toArray();

        $I->assertTrue(isset($pipelines[0]['id']));
    }

    /**
     * Test pipeline by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetPipelineById(IntegrationTester $I) : void
    {
        $newPipeline = $this->dataBuilder->createPipeline();
        $pipeline = Pipelines::getById($newPipeline->getId(), new Users());

        $I->assertEquals($pipeline->getId(), $newPipeline->getId());
    }


    /**
     * Update pipeline
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testUpdatePipeline(IntegrationTester $I) : void
    {
        $pipeline = $this->dataBuilder->createPipeline();
        $updatedPipeline = Pipelines::update($pipeline, "Update Pipeline");

        $I->assertEquals($updatedPipeline->name, $pipeline->name);
    }
}
