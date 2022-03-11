<?php

declare(strict_types=1);

namespace Kanvas\Guild\Leads;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Leads\Models\Types;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;

class LeadsTypes
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new Types();
    }

    /**
     * Create a new lead type
     *
     * @param UserInterface $user
     * @param string $name
     * @param string $description
     * @param integer|null $appId
     * @return Types
     */
    public static function create(UserInterface $user, string $name, string $description = '', int $appId = null) : Types
    {
        $newType = new Types();
        $newType->companies_id = $user->currentCompanyId();
        $newType->name = $name;
        $newType->description = $description;
        $newType->apps_id = $appId ?? 1;
        $newType->saveOrFail();

        return $newType;
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
