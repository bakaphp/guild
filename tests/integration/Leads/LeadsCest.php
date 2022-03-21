<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Leads;

use IntegrationTester;
use Kanvas\Guild\Leads\Leads;
use Kanvas\Guild\Leads\LeadsTypes;
use Kanvas\Guild\Leads\Models\Leads as ModelsLeads;
use Kanvas\Guild\Leads\Models\Types as ModelLeadTypes;
use Kanvas\Guild\Organizations\Models\Organizations as ModelsOrganizations;
use Kanvas\Guild\Rotations\Agents;
use Kanvas\Guild\Tests\Support\BaseIntegration;
use Kanvas\Guild\Tests\Support\Models\Users;

class LeadsCest extends BaseIntegration
{
    public ModelsOrganizations $organization;

    /**
     * Test creation of leads
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreateLead(IntegrationTester $I) : void
    {
        $receiver = $this->dataBuilder->createReceiver();
        $rotation = $receiver->getRotation();
        $agent = Agents::create($rotation, new Users(), $receiver, 1.0, 3);

        $newLead = Leads::create(
            new Users(),
            'Title',
            $this->dataBuilder->createPipelineStage(),
            $agent,
            $this->dataBuilder->createPeople(),
            $this->dataBuilder->createOrganization(),
            $this->dataBuilder->createLeadType(),
            $this->dataBuilder->createLeadStatus(),
            $this->dataBuilder->createLeadSource(),
            false,
            'Lead created for testing'
        );

        $I->assertInstanceOf(ModelsLeads::class, $newLead);
        $I->assertNotNull($newLead->getId());
    }

    /**
     * Test Create lead type
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreateLeadType(IntegrationTester $I) : void
    {
        $name = "Internet";
        $description = "Description about this so can be join maybe lol";

        $newType = LeadsTypes::create(new Users(), $name, $description);

        $I->assertInstanceOf(ModelLeadTypes::class, $newType);
        $I->assertNotNull($newType->getId());
    }

    /**
     * Test get all leads
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAllLeads(IntegrationTester $I) : void
    {
        $this->dataBuilder->createLead();

        $leads = Leads::getAll(new Users())->toArray();

        $I->assertTrue(isset($leads[0]['id']));
    }

    /**
     * Test get lead by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetLeadTypeById(IntegrationTester $I) : void
    {
        $newLead = $this->dataBuilder->createLead();
        $lead = Leads::getById($newLead->getId(), new Users());

        $I->assertEquals($lead->getId(), $newLead->getId());
    }

        /**
     * Test get all leads
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAllLeadsTypes(IntegrationTester $I) : void
    {
        $this->dataBuilder->createLeadType();

        $type = LeadsTypes::getAll(new Users())->toArray();

        $I->assertTrue(isset($type[0]['id']));
    }

    /**
     * Test get lead type by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetLeadById(IntegrationTester $I) : void
    {
        $newType = $this->dataBuilder->createLeadType();
        $type = LeadsTypes::getById($newType->getId(), new Users());

        $I->assertEquals($type->getId(), $newType->getId());
    }
}
