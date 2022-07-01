<?php

declare(strict_types=1);

namespace Kanvas\Guild\Leads\Models;

use Baka\Database\Behaviors\Uuid;
use Canvas\Contracts\CustomFields\CustomFieldsTrait;
use Kanvas\Guild\Activities\Models\Activities;
use Kanvas\Guild\BaseModel;
use Kanvas\Guild\Contracts\LeadsInterface;
use Kanvas\Guild\Deals\Models\Deals;
use Kanvas\Guild\Participants\Models\Participants as ModelParticipants;
use Kanvas\Guild\Participants\Models\Types as ParticipantsTypes;
use Kanvas\Guild\Participants\Participants;
use Kanvas\Guild\Peoples\Models\Peoples;

class Leads extends BaseModel implements LeadsInterface
{
    use CustomFieldsTrait;

    public string $uuid;
    public ?int $apps_id = 0;
    public int $users_id;
    public int $companies_id;
    public ?int $companies_branches_id = 0;
    public int $leads_receivers_id;
    public int $leads_owner_id;
    public int $leads_status_id;
    public int $pipeline_stage_id;
    public ?int $people_id = null;
    public ?int $organization_id = null;
    public int $leads_types_id;
    public ?int $leads_sources_id = null;
    public ?string $reason_lost = null;
    public string $title;
    public ?string $description = null;
    public int $is_duplicated = 0;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('leads');

        $this->addBehavior(
            new Uuid()
        );

        $this->hasOne(
            'id',
            Deals::class,
            'leads_id',
            [
                'reusable' => true,
                'alias' => 'deal'
            ]
        );

        $this->hasMany(
            'id',
            Activities::class,
            'leads_id',
            [
                'reusable' => true,
                'alias' => 'deal'
            ]
        );
    }

    /**
     * Add a new participant to the current lead.
     *
     * @param Peoples $people
     * @param ParticipantsTypes $participantType
     * @return Participants
     */
    public function addParticipant(Peoples $people, ParticipantsTypes $participantType) : ModelParticipants
    {
        return Participants::add($this, $people, $participantType);
    }
}
