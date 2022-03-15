<?php

declare(strict_types=1);

namespace Kanvas\Guild\Participants;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Leads\Models\Leads as ModelsLeads;
use Kanvas\Guild\Participants\Models\Participants as ModelParticipants;
use Kanvas\Guild\Participants\Models\Types as ParticipantsTypes;
use Kanvas\Guild\Peoples\Models\Peoples;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;

class Participants
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ModelParticipants();
    }

    /**
     * Add a new people participant to the lead.
     *
     * @param ModelsLeads $lead
     * @param Peoples $people
     * @param ParticipantsTypes $type
     * @return ModelParticipants
     */
    public static function add(ModelsLeads $lead, Peoples $people, ParticipantsTypes $type) : ModelParticipants
    {
        $newParticipant = new ModelParticipants();
        $newParticipant->leads_id = $lead->getId();
        $newParticipant->peoples_id = $people->getId();
        $newParticipant->participants_types_id = $type->getId();

        return $newParticipant;
    }

    /**
     * Create a new participant type.
     *
     * @param UserInterface $user
     * @param string $name
     * @return ParticipantsTypes
     */
    public static function createParticipantType(UserInterface $user, string $name, int $appId = null) : ParticipantsTypes
    {
        $newType = new ParticipantsTypes();
        $newType->name = $name;
        $newType->companies_id = $user->currentCompanyId();
        $newType->apps_id = $appId ?? 1;
        $newType->saveOrFail();

        return $newType;
    }
}
