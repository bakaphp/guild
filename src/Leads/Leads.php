<?php

declare(strict_types=1);

namespace Kanvas\Guild\Leads;

use Baka\Contracts\Database\ModelInterface;
use Baka\Database\Model;
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
        $agent->increaseHit();

        return $newLead;
    }

    /**
     * Get Leads by status
     *
     * @param integer $statusId
     * @param UserInterface $user
     * @param integer $page
     * @param integer $limit
     * @return ResultsetInterface
     */
    public static function getByStatus(int $statusId, UserInterface $user, int $page = 1, int $limit = 10) : ResultsetInterface
    {
        $offset = ($page - 1) * $limit;

        return ModelsLeads::find([
            'conditions' => 'companies_id = :company_id: AND  status = :status: AND is_deleted = 0',
            'bind' => [
                'company_id' => $user->currentCompanyId(),
                'status' => $statusId
            ],
            'limit' => $limit,
            'offset' => $offset
        ]);
    }
}
