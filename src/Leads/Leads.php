<?php

declare(strict_types=1);

namespace Kanvas\Guild\Leads;

use Baka\Contracts\Database\ModelInterface;
use Exception;
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
use Kanvas\Guild\Leads\Models\Receivers as ModelsReceivers;

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
     * Create a new lead
     *
    * @param array $data Array containing the necessary params.
    *    $data = [
    *      'title'               => (string) Title of the lead. Required
    *      'description'         => (string) Description of the lead.
    *      'stage'               => (ModelsStages) The initial stage of the lead pipeline. Required.
    *      'receiver'            => (ModelsReceivers) The receiver of the lead. Required.
    *      'agent'               => (LeadsRotationsAgents) The agent owner of the lead. Required.
    *      'people'              => (Peoples) The people entity related to the lead.
    *      'organization'        => (Organizations) The organization entity related to the lead.
    *      'lead_type'           => (ModelTypes) Lead type. Required.
    *      'lead_status'         => (ModelStatus) The current lead status. Required.
    *      'lead_source'         => (ModelSource) The lead initial source.
    *      'is_duplicate'        => (boolean) Check if the lead is a duplicate. Default: false.
    *    ]
    * @param UserInterface $user
    * @return ModelsLeads
    */
    public static function create(array $data, UserInterface $user) : ModelsLeads
    {

        $properties = [
            'stage' => ModelsStages::class,
            'receiver' => ModelsReceivers::class,
            'agent' => LeadsRotationsAgents::class,
            'people' => Peoples::class,
            'organization' => Organizations::class,
            'lead_type' => Types::class,
            'lead_status' => Status::class,
            'lead_source' => Source::class,
            'title' => 'string',
            'description' => 'string',
            'is_duplicate' => 'boolean'
        ];

        $data = self::validateData($properties, $data);

        $newLead = new ModelsLeads();
        $newLead->users_id =  $user->getId();
        $newLead->companies_id =  $user->currentCompanyId();
        $newLead->leads_owner_id = $data['agent']->users_id;
        $newLead->leads_receivers_id =  $data['receiver']->getId();
        $newLead->leads_status_id =  $data['lead_status']->getId();
        $newLead->leads_sources_id =  $data['lead_source']->getId() ?? 0;
        $newLead->leads_types_id =  $data['lead_type']->getId();
        $newLead->pipeline_stage_id =  $data['stage']->getId();
        $newLead->people_id =  $data['people'] ? $data['people']->getId() : null;
        $newLead->organization_id =  $data['organization'] ? $data['organization']->getId() : null;
        $newLead->title = $data['title'];
        $newLead->description = $data['description'] ?? '';
        $newLead->is_duplicated = (int)$data['is_duplicate'] ?? 0;
        $newLead->saveOrFail();

        $data['receiver']->incrementTotalLeads();
        $data['agent']->increaseHit();

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

    /**
     * Validate data for leads
     *
     * @param array $validation
     * @param array $data
     * @return array
     */
    public static function validateData(array $validation, array $data): array
    {
        foreach ($validation as $key => $type) {
            if (isset($data[$key]) && gettype($data[$key] == $type) && $data[$key] instanceof $type) {
                continue;
            }
            if (isset($data[$key]) && gettype($data[$key]) !== $type) {
                throw new Exception("{$key} must be an instance of {$type}");
            } elseif(isset($data[$key]) && gettype($data[$key]) === $type) {
                continue;
            }
            $data[$key] = null;
        }
        return $data;
    }
}
