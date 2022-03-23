<?php
namespace Helper\DataBuilder;

use Kanvas\Guild\Participants\Models\Types;
use Kanvas\Guild\Participants\Types as ParticipantsTypes;
use Kanvas\Guild\Tests\Support\Models\Users;

class Participants
{
    /**
     * Create a new Participants Types
     *
     * @return Types
     */
    public static function createParticipantsType() : Types
    {
        return ParticipantsTypes::create(new Users(), 'Owner');
    }
}
