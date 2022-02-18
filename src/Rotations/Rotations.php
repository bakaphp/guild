<?php

declare(strict_types=1);

namespace Kanvas\Guild\Rotations;

use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Kanvas\Guild\Rotations\Models\Rotations as ModelsRotations;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Utils\Slug;

class Rotations
{
    /**
     * Create a new rotation
     *
     * @param string $name
     * @param UserInterface $user
     * @return ModelsPipelines
     */
    public static function create(string $name, UserInterface $user) : ModelsRotations
    {
        $rotation = new ModelsRotations();
        $rotation->name = $name;
        $rotation->users_id = $user->getId();
        $rotation->companies_id = $user->currentCompanyId();
        $rotation->slug = Slug::generate($name);
        $rotation->saveOrFail();

        return $rotation;
    }

    /**
     * Get all rotations associated to a company
     *
     * @param integer $page
     * @param integer $limit
     * @return ResultsetInterface
     */
    public static function getAll(UserInterface $user, $page = 1, $limit = 10) : ResultsetInterface
    {
        $offset = ($page - 1) * $limit;

        $rotations = ModelsRotations::find([
            'conditions' => 'companies_id = :company_id: AND is_deleted = 0',
            'bind' => [
                'company_id' => $user->currentCompanyId()
            ],
            'limit' => $limit,
            'offset' => $offset
        ]);

        return $rotations;
    }

    /**
     * Get a rotation by its id
     *
     * @param integer $id
     * @return ModelsRotations
     */
    public static function getById(int $id, UserInterface $user) : ModelsRotations
    {
        return ModelsRotations::findFirstOrFail(
            [
                'conditions' => 'id = :id: AND companies_id = :companies_id: AND is_deleted = 0',
                'bind' => [
                    'id' => $id,
                    'companies_id' => $user->currentCompanyId(),
                ]
            ]
        );
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
        $rotation->slug = Slug::generate($name);
        $rotation->saveOrFail();

        return $rotation;
    }
}
