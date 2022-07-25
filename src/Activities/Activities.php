<?php

declare(strict_types=1);

namespace Kanvas\Guild\Activities;

use Baka\Contracts\Database\ModelInterface;
use Cake\Datasource\ResultSetInterface;
use Kanvas\Guild\Activities\Models\Activities as ModelsActivities;
use Kanvas\Guild\Activities\Models\ActivitiesStatus;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Activities\Models\ActivitiesTypes;
use Kanvas\Guild\Contracts\LeadsInterface;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;

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
     * Create a new activities status.
     *
     * @param UserInterface $user
     * @param string $name
     * @return ActivitiesStatus
     */
    public static function createStatus(UserInterface $user, string $name, bool $isDefault = false) : ActivitiesStatus
    {
        $newStatus = new ActivitiesStatus();
        $newStatus->name = $name;
        $newStatus->companies_id = $user->currentCompanyId();
        $newStatus->is_default = (int) $isDefault;
        $newStatus->saveOrFail();

        return $newStatus;
    }

    /**
     * Get activities by status.
     *
     * @param UserInterface $user
     * @param ActivitiesStatus $status
     * @return ResultSetInterface
     */
    public static function getActivitiesByStatus(UserInterface $user, ActivitiesStatus $status) : ResultSetInterface
    {
        return Activities::find([
            'conditions' => 'companies_id = :companies_id: AND activities_status_id = :status_id: AND is_deleted = 0',
            'bind' => [
                'companies_id' => $user->currentCompanyId(),
                'status_id' => $status->getId()
            ]
        ]);
    }

    /**
     * Get default activity status if exist.
     *
     * @param UserInterface $user
     * @return ActivitiesStatus|null
     */
    public static function getActivityDefaultStatus(UserInterface $user) : ?ActivitiesStatus
    {
        return ActivitiesStatus::findFirst([
            'conditions' => 'companies_id = :company_id: AND is_default = 1 AND is_deleted = 0',
            'bind' => [
                'company_id' => $user->currentCompanyId()
            ]
        ]);
    }
}
