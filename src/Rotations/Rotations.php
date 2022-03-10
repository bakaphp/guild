<?php

declare(strict_types=1);

namespace Kanvas\Guild\Rotations;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Kanvas\Guild\Rotations\Models\LeadsRotationsAgents;
use Kanvas\Guild\Rotations\Models\Rotations as ModelsRotations;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;

class Rotations
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ModelsRotations();
    }

    /**
     * Create a new rotation
     *
     * @param string $name
     * @param UserInterface $user
     * @return ModelsRotations
     */
    public static function create(string $name, UserInterface $user) : ModelsRotations
    {
        $rotation = new ModelsRotations();
        $rotation->name = $name;
        $rotation->users_id = $user->getId();
        $rotation->companies_id = $user->currentCompanyId();
        $rotation->saveOrFail();

        return $rotation;
    }

    /**
     * Get rotation by name
     *
     * @param string $name
     * @param UserInterface $user
     * @return ModelsRotations
     */
    public static function getByName(string $name, UserInterface $user) : ModelsRotations
    {
        return ModelsRotations::findFirstOrFail(
            [
                'conditions' => 'name = :name: AND companies_id = :companies_id: AND is_deleted = 0',
                'bind' => [
                    'name' => $name,
                    'companies_id' => $user->currentCompanyId()
                ]
            ]
        );
    }

    /**
     * Update pipeline
     *
     * @param ModelsRotations $pipeline
     * @param string $name
     * @return ModelsRotations
     */
    public static function update(ModelsRotations $rotation, string $name) : ModelsRotations
    {
        $rotation->name = $name;
        $rotation->saveOrFail();

        return $rotation;
    }
}
