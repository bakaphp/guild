<?php

declare(strict_types=1);

namespace Kanvas\Guild\Leads;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Leads\Models\Receivers as ModelsReceivers;
use Kanvas\Guild\Organizations\Models\Organizations as ModelsOrganizations;
use Kanvas\Guild\Organizations\Models\OrganizationsPeoples;
use Kanvas\Guild\Peoples\Models\Peoples;
use Kanvas\Guild\Rotations\Models\Rotations;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;
use Phalcon\Utils\Slug;

class Receivers
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ModelsReceivers();
    }

    /**
     * Create a new receiver
     *
     * @param UserInterface $user
     * @param string $name
     * @param Rotations $rotation
     * @param string $sourceName
     * @param boolean $isDefault
     * @return ModelsReceivers
     */
    public static function create(UserInterface $user, string $name, Rotations $rotation, string $sourceName, bool $isDefault = false) : ModelsReceivers
    {
        $receiver = new ModelsReceivers();
        $receiver->companies_id = $user->currentCompanyId();
        $receiver->name = $name;
        $receiver->users_id = $user->getId();
        $receiver->agents_id = $user->getId();
        $receiver->rotations_id = $rotation->getId();
        $receiver->source_name = $sourceName;
        $receiver->is_default = (int) $isDefault;
        $receiver->saveOrFail();

        return $receiver;
    }

    /**
     * Update receiver
     *
     * @param ModelsReceivers $organization
     * @param array $data
     * @param Rotations $rotation
     * @return ModelsReceivers
     */
    public static function update(ModelsReceivers $receiver, array $data, ?Rotations $rotation = null) : ModelsReceivers
    {
        $updateFields = [
            'name',
            'source_name',
            'rotations_id'
        ];

        $data['rotations_id'] = $rotation->getId() ?? $receiver->rotations_id;

        $receiver->saveOrFail($data, $updateFields);

        return $receiver;
    }
}
