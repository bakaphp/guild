<?php

declare(strict_types=1);

namespace Kanvas\Guild\Participants;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Participants\Models\Types as ParticipantsTypes;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;

class Types
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ParticipantsTypes();
    }

    /**
     * Create a new participant type
     *
     * @param UserInterface $user
     * @param string $name
     * @param integer $appId
     * @return ParticipantsTypes
     */
    public static function create(UserInterface $user, string $name, int $appId = 0) : ParticipantsTypes
    {
        $newType = new ParticipantsTypes();
        $newType->name = $name;
        $newType->companies_id = $user->currentCompanyId();
        $newType->apps_id = $appId;
        $newType->saveOrFail();

        return $newType;
    }

    /**
     * Update participant type
     *
     * @param ParticipantsTypes $type
     * @param array $data
     * @return ParticipantsTypes
     */
    public static function update(ParticipantsTypes $type, array $data) : ParticipantsTypes
    {
        $updateFields = [
            'name'
        ];

        $type->saveOrFail($data, $updateFields);

        return $type;
    }
}
