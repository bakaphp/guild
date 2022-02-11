<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Pipelines;

use IntegrationTester;
use Kanvas\Guild\Pipelines\Pipelines;
use Kanvas\Guild\Tests\Support\Models\Missions;

class PipelinesCest
{
    public function testCreatePipeline(IntegrationTester $I) : void
    {
        $name = "Thinking";

        $pipeline = Pipelines::create($name, new Missions());

        $I->assertEquals($name, $pipeline->name);
    }
}
