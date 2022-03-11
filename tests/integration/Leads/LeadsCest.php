<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Pipelines;

use IntegrationTester;
use Kanvas\Guild\Leads\Leads;
use Kanvas\Guild\Leads\LeadsTypes;
use Kanvas\Guild\Leads\Models\Leads as ModelsLeads;
use Kanvas\Guild\Leads\Models\Source;
use Kanvas\Guild\Leads\Models\Status;
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
            $this->createLeadType(),
            $this->createLeadStatus(),
            $this->createLeadSource(),
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
     * Create lead type for testing
     *
     * @return ModelLeadTypes
     */
    private function createLeadType() : ModelLeadTypes
    {
        $name = "Type No.".rand();
        $description = "Description about this so can be join maybe lol";

        $newType = LeadsTypes::create(new Users(), $name, $description);
        return $newType;
    }

    /**
     * Create lead status for tests
     *
     * @return Status
     */
    private function createLeadStatus() : Status
    {
        $status = new Status();
        $status->name = "Pending";
        $status->saveOrFail();

        return $status;
    }

    /**
     * Create lead source for testing
     *
     * @return Source
     */
    private function createLeadSource() : Source
    {
        $user = new Users();
        $status = new Source();
        $status->name = "Pending";
        $status->companies_id = $user->currentCompanyId();
        $status->saveOrFail();

        return $status;
    }
}
