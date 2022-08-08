<?php

declare(strict_types=1);

namespace Kanvas\Guild\Activities;

use Baka\Contracts\Database\ModelInterface;
use Cake\Datasource\ResultSetInterface;
use Kanvas\Guild\Activities\Models\ActivitiesStatus;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;

class Status
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ActivitiesStatus();
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

    /**
     * Get activities status by name.
     *
     * @param UserInterface $user
     * @param string $name
     * @return ActivitiesStatus
     */
    public static function getStatusByName(UserInterface $user, string $name) :  ActivitiesStatus
    {
        return ActivitiesStatus::findFirstOrFail([
            'conditions' => 'companies_id = :company_id: AND name = :name: AND is_deleted = 0',
            'bind' => [
                'company_id' => $user->currentCompanyId(),
                'name' => $name
            ]
        ]);
    }
}
