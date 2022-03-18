<?php
namespace Helper\DataBuilder;

use Kanvas\Guild\Participants\Models\Types as ParticipantsTypes;
use Kanvas\Guild\Participants\Models\Participants as ModelsParticipants;
use Kanvas\Guild\Participants\Participants as ParticipantsMethods;
use Kanvas\Guild\Tests\Support\Models\Users;

class Participants
{
    /**
     * Create a new Participants Types
     *
     * @return ParticipantsTypes
     */
    public static function createParticipantsType() : ParticipantsTypes
    {
        return ParticipantsMethods::createParticipantType(new Users(), 'Owner');
    }
}
