<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Participants;

use IntegrationTester;
use Kanvas\Guild\Deals\Deals;
use Kanvas\Guild\Deals\Models\Deals as ModelsDeals;
use Kanvas\Guild\Participants\Models\Participants as ModelsParticipants;
use Kanvas\Guild\Participants\Models\Types;
use Kanvas\Guild\Participants\Participants;
use Kanvas\Guild\Tests\Support\BaseIntegration;
use Kanvas\Guild\Tests\Support\Models\Users;

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

        $participant = Participants::addParticipant(
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
        $type = Participants::createParticipantType(new Users(), "Test owner");

        $I->assertInstanceOf(Types::class, $type);
        $I->assertNotNull($type->getId());
    }
}
