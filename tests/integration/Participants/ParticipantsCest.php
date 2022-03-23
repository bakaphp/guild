<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Participants;

use IntegrationTester;
use Kanvas\Guild\Participants\Models\Participants as ModelsParticipants;
use Kanvas\Guild\Participants\Models\Types;
use Kanvas\Guild\Participants\Participants;
use Kanvas\Guild\Tests\Support\BaseIntegration;
use Kanvas\Guild\Tests\Support\Models\Users;
use Kanvas\Guild\Participants\Types as ParticipantsTypes;

class ParticipantsCest extends BaseIntegration
{
    /**
     * Test create deal
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreateParticipants(IntegrationTester $I) : void
    {
        $participant = Participants::add(
            $this->dataBuilder->createLead(),
            $this->dataBuilder->createPeople(),
            $this->dataBuilder->createParticipantsType()
        );

        $I->assertInstanceOf(ModelsParticipants::class, $participant);
        $I->assertNotNull($participant->getId());
    }

    /**
     * Test create a participants type
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreateParticipantsType(IntegrationTester $I) : void
    {
        $type = ParticipantsTypes::create(new Users(), "Test owner");

        $I->assertInstanceOf(Types::class, $type);
        $I->assertNotNull($type->getId());
    }


    /**
     * Test update participants type
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testUpdateParticipantsType(IntegrationTester $I) : void
    {
        $type = $this->dataBuilder->createParticipantsType();

        $data = [
            'name' => 'New Name'
        ];

        $edited = ParticipantsTypes::update($type, $data);

        $I->assertEquals($data['name'], $edited->name);
    }

    /**
     * Test get all participants types
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAllParticipantsTypes(IntegrationTester $I) : void
    {
        $this->dataBuilder->createParticipantsType();

        $types = ParticipantsTypes::getAll(new Users())->toArray();

        $I->assertTrue(isset($types[0]['id']));
    }

    /**
     * Test get participants types by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetParticipantsTypeById(IntegrationTester $I) : void
    {
        $newTypes = $this->dataBuilder->createParticipantsType();
        $type = ParticipantsTypes::getById($newTypes->getId(), new Users());

        $I->assertEquals($type->getId(), $newTypes->getId());
    }
}
