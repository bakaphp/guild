<?php

declare(strict_types=1);

namespace Kanvas\Guild\Leads;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Leads\Models\Leads as ModelsLeads;
use Kanvas\Guild\Leads\Models\Source;
use Kanvas\Guild\Leads\Models\Status;
use Kanvas\Guild\Leads\Models\Types;
use Kanvas\Guild\Organizations\Models\Organizations;
use Kanvas\Guild\Peoples\Models\Peoples;
use Kanvas\Guild\Pipelines\Models\Stages as ModelsStages;
use Kanvas\Guild\Rotations\Models\LeadsRotationsAgents;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;

class Leads
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ModelsLeads();
    }

    /**
     * Create a new Lead
     *
     * @param UserInterface $user
     * @param string $title
     * @param ModelsStages $pipelineStage
     * @param LeadsRotationsAgents $agent
     * @param Organizations $organization
     * @param Types $leadType
     * @param Status $leadStatus
     * @param Source $leadSource
     * @param boolean $isDuplicate
     * @param string $description
     * @return ModelsLeads
     */
    public static function create(UserInterface $user, string $title, ModelsStages $pipelineStage, LeadsRotationsAgents $agent, Peoples $people, Organizations $organization, Types $leadType, Status $leadStatus, Source $leadSource, bool $isDuplicate, string $description = '') : ModelsLeads
    {
        $newLead = new ModelsLeads();
        $newLead->users_id =  $user->getId();
        $newLead->companies_id =  $user->currentCompanyId();
        $newLead->leads_owner_id = $agent->users_id;
        $newLead->leads_receivers_id =  $agent->receivers_id;
        $newLead->leads_status_id =  $leadStatus->getId();
        $newLead->leads_sources_id =  $leadSource->getId();
        $newLead->leads_types_id =  $leadType->getId();
        $newLead->pipeline_stage_id =  $pipelineStage->getId();
        $newLead->people_id =  $people->getId();
        $newLead->organization_id =  $organization->getId();
        $newLead->title = $title;
        $newLead->description = $description ?? '';
        $newLead->is_duplicated = (int)$isDuplicate;
        $newLead->saveOrFail();

        $agent->getReceiver()->incrementTotalLeads();

        return $newLead;
    }

    /**
     * Update leads type
     *
     * @param Types $leadType
     * @param array $data
     * @return Types
     */
    public static function update(Types $leadType, array $data) : Types
    {
        $updateFields = [
            'name',
            'description',
        ];

        $leadType->saveOrFail($data, $updateFields);

        return $leadType;
    }
}
