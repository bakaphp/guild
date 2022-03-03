<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Pipelines;

use IntegrationTester;
use Kanvas\Guild\Organizations\Models\Organizations as ModelsOrganizations;
use Kanvas\Guild\Organizations\Models\OrganizationsPeoples;
use Kanvas\Guild\Organizations\Organizations;
use Kanvas\Guild\Peoples\Peoples;
use Kanvas\Guild\Tests\Support\Models\Users;

class OrganizationsCest
{
    public ModelsOrganizations $organization;

    /**
     * Test create a new pipeline
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreateOrganization(IntegrationTester $I) : void
    {
        $data = [
            'name' => 'organization name 1',
            'address' => 'Lomina 22, #44, Santo domingo Arriba'
        ];

        $organization = Organizations::create($data, new Users());

        $this->organization = $organization;

        $I->assertEquals($data['name'], $organization->name);
        $I->assertEquals($data['address'], $organization->address);
    }

    /**
     * Get all organizations
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAllOrganizations(IntegrationTester $I) : void
    {
        $organizations = Organizations::getAll(new Users())->toArray();

        $I->assertTrue(isset($organizations[0]['id']));
    }

    /**
     * Test organizations by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetOrganizationById(IntegrationTester $I) : void
    {
        $organization = Organizations::getById($this->organization->getId(), new Users());

        $I->assertEquals($organization->getId(), $this->organization->getId());
    }


    /**
     * Update pipeline
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testUpdatePipeline(IntegrationTester $I) : void
    {
        $updateData = [
            'name' => 'organization name update',
            'address' => 'Lomina 11, #22, Santo domingo Abajo'
        ];

        $organization = Organizations::update($this->organization, $updateData);

        $I->assertEquals($organization->name, $this->organization->name);
    }

    /**
     * Test add people to an organization
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testAddPeopleOrganization(IntegrationTester $I) : void
    {
        $peopleData = [
            'name' => 'Organizerino Empredieur',
        ];

        $organizationData = [
            'name' => 'organization name 1',
            'address' => 'Lomina 22, #44, Santo domingo Arriba'
        ];

        $organization = Organizations::create($organizationData, new Users());

        $people = Peoples::create($peopleData, new Users());

        $organizationPeoples = Organizations::addPeople($organization, $people);

        $I->assertInstanceOf(OrganizationsPeoples::class, $organizationPeoples);
        $I->assertEquals(
            $organization->getId(),
            $people->getOrganizations()->toArray()[0]['id']
        );
    }
}
