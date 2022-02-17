<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Pipelines;

use IntegrationTester;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Kanvas\Guild\Pipelines\Pipelines;
use Kanvas\Guild\Tests\Support\Models\Missions;
use Kanvas\Guild\Tests\Support\Models\Users;

class PipelinesCest
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
        $pipeline = Pipelines::getById($this->pipeline->getId(), new Users());

        $I->assertEquals($pipeline->getId(), $this->pipeline->getId());
    }


    /**
     * Update pipeline
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testUpdatePipeline(IntegrationTester $I) : void
    {
        $pipeline = Pipelines::update($this->pipeline, "Update Pipeline");

        $I->assertEquals($pipeline->name, $this->pipeline->name);
    }
}
