<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Rotations;

use IntegrationTester;
use Kanvas\Guild\Rotations\Agents;
use Kanvas\Guild\Rotations\Models\LeadsRotationsAgents;
use Kanvas\Guild\Rotations\Models\Rotations as ModelsRotations;
use Kanvas\Guild\Tests\Support\Models\Users;

class AgentsCest
{
    public ModelsRotations $rotations;
    public LeadsRotationsAgents $agent;

    /**
     * Test create a new agent
     * @before getRotation
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreateAgents(IntegrationTester $I) : void
    {
        $user = new Users();
        $user->phone_number = "809-909-8811";

        $agent = Agents::create($this->rotations, $user, 0.5, 3);

        $this->agent = $agent;

        $I->assertInstanceOf(LeadsRotationsAgents::class, $agent);
    }

    /**
     * Test get all creation by rotations
     * @before getRotation
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAgentsByRotations(IntegrationTester $I) : void
    {
        $agents = Agents::getAgentsFromRotation($this->rotations, 1, 2)->toArray();

        $I->assertTrue(isset($agents[0]['id']));
    }

    /**
     * Get agents by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAgentsById(IntegrationTester $I) : void
    {
        $agent = Agents::create($this->rotations, new Users(), 0.5, 3);
        $agent = Agents::getById($agent->getId(), new Users());

        $I->assertInstanceOf(LeadsRotationsAgents::class, $agent);
    }

    /**
     * Update agents data
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testEditRotationAgent(IntegrationTester $I) : void
    {
        $agent = Agents::create($this->rotations, new Users(), 0.5, 3);
        $data = [
            'phone' => '1-998-093-2344',
            'percent' => 0.54,
            'hits' => 3
        ];

        $agent = Agents::updateAgent($agent, $data);

        $I->assertEquals($data['phone'], $agent->phone);
    }

    /**
     * Set a rotation
     *
     * @return void
     */
    private function getRotation() : void
    {
        $this->rotations = ModelsRotations::findFirst();
    }
}
