<?php

declare(strict_types=1);

namespace Kanvas\Guild\Activities;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Activities\Models\Activities as ModelsActivities;
use Kanvas\Guild\Activities\Models\ActivitiesStatus;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Activities\Models\ActivitiesTypes;
use Kanvas\Guild\Contracts\LeadsInterface;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;
use Phalcon\Mvc\Model\ResultsetInterface;

class Activities
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ModelsActivities();
    }

    /**
     * Create a new activity.
     *
     * @param UserInterface $user
     * @param string $title
     * @param string $start
     * @param string $end
     * @param LeadsInterface $lead
     * @param ActivitiesTypes $type
     * @param ActivitiesStatus $status
     * @param string $description
     * @param integer $appId
     * @return ModelsActivities
     */
    public static function create(UserInterface $user, string $title, string $start, string $end, LeadsInterface $lead, ActivitiesTypes $type, ActivitiesStatus $status, string $description, int $appId = 0) : ModelsActivities
    {
        $activity = new ModelsActivities();
        $activity->companies_id = $user->currentCompanyId();
        $activity->leads_id = $lead->getId();
        $activity->title = $title;
        $activity->start_date = $start;
        $activity->end_date = $end;
        $activity->activity_type_id = $type->getId();
        $activity->activities_status_id = $status->getId();
        $activity->organization_id = $lead->organization_id;
        $activity->description = $description;
        $activity->apps_id = $appId;
        $activity->saveOrFail();

        return $activity;
    }


    /**
     * Update an activity.
     *
     * @param ModelsActivities $activity
     * @param array $data
     * @return ModelsActivities
     */
    public static function update(ModelsActivities $activity, array $data) : ModelsActivities
    {
        $updateFields = [
            'title',
            'description',
            'start_date',
            'end_date',
            'is_complete',
        ];

        $activity->saveOrFail($data, $updateFields);

        return $activity;
    }

    /**
     * Create a new activity type
     *
     * @param UserInterface $user
     * @param string $name
     * @param string $description
     * @return ActivitiesTypes
     */
    public static function createType(UserInterface $user, string $name, string $description = '', ?int $appId = 0) : ActivitiesTypes
    {
        $newType = new ActivitiesTypes();
        $newType->name = $name;
        $newType->description = $description;
        $newType->companies_id = $user->currentCompanyId();
        $newType->apps_id = $appId;
        $newType->saveOrFail();

        return $newType;
    }


    /**
     * Get activities by lead.
     *
     * @param LeadsInterface $lead
     * @return ResultsetInterface
     */
    public static function getByLead(LeadsInterface $lead) : ResultsetInterface
    {
        return ModelsActivities::find([
            'conditions' => 'leads_id = :lead_id: AND is_deleted = 0',
            'bind' => [
                'lead_id' => $lead->getId()
            ]
        ]);
    }
}
