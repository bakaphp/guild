<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Pipelines;

use IntegrationTester;
use Kanvas\Guild\Peoples\Models\Peoples as ModelsPeoples;
use Kanvas\Guild\Peoples\Peoples;
use Kanvas\Guild\Tests\Support\Models\Users;

class PeoplesCest
{
    public ModelsPeoples $people;

    /**
     * Test create a new people
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreatePeople(IntegrationTester $I) : void
    {
        $data = [
            'name' => 'Castillo Choza P.',
            'email' => 'CascasP@mail.com'
        ];

        $people = Peoples::create($data, new Users());

        $this->people = $people;

        $I->assertEquals($data['name'], $people->name);
    }

    /**
     * Get all peoples
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAllPeoples(IntegrationTester $I) : void
    {
        $peoples = Peoples::getAll(new Users())->toArray();

        $I->assertTrue(isset($peoples[0]['id']));
    }

    /**
     * Test peoples by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetPeopleById(IntegrationTester $I) : void
    {
        $people = Peoples::getById($this->people->getId(), new Users());

        $I->assertEquals($people->getId(), $this->people->getId());
    }


    /**
     * Update people
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testUpdatePeople(IntegrationTester $I) : void
    {
        $updateData = [
            'name' => 'Casa actualizada',
        ];

        $people = Peoples::update($this->people, $updateData);

        $I->assertEquals($people->name, $this->people->name);
    }
}
