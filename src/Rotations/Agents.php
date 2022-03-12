<?php

declare(strict_types=1);

namespace Kanvas\Guild\Rotations;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Leads\Models\Receivers;
use Kanvas\Guild\Rotations\Models\LeadsRotationsAgents;
use Kanvas\Guild\Rotations\Models\Rotations as ModelsRotations;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;
use Phalcon\Mvc\Model\ResultsetInterface;

class Agents
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new LeadsRotationsAgents();
    }

    /**
     * Create a new Agent
     *
     * @param ModelsRotations $rotation
     * @param UserInterface $user
     * @param float $percent
     * @param integer $hits
     * @return LeadsRotationsAgents
     */
    public static function create(ModelsRotations $rotation, UserInterface $user, Receivers $receiver, float $percent, int $hits) : LeadsRotationsAgents
    {
        $agent = new LeadsRotationsAgents();
        $agent->rotations_id = $rotation->getId();
        $agent->companies_id = $rotation->companies_id;
        $agent->receivers_id = $receiver->getId();
        $agent->users_id = $user->getId();
        $agent->phone = $user->phone_number ?? '';
        $agent->percent = $percent;
        $agent->hits = $hits;
        $agent->saveOrFail();

        return $agent;
    }

    /**
     * Get all agents from a rotation
     *
     * @param ModelsRotations $rotation
     * @param integer $page
     * @param integer $limit
     * @return ResultsetInterface
     */
    public static function getAgentsFromRotation(ModelsRotations $rotation, int $page = 1, int $limit = 10) : ResultsetInterface
    {
        $offset = ($page - 1) * $limit;
        $model = self::getModel();

        $data = $model::find([
            'conditions' => 'rotations_id = :rotation_id: AND companies_id = :company_id: AND is_deleted = 0',
            'bind' => [
                'company_id' => $rotation->companies_id,
                'rotation_id' => $rotation->getId()
            ],
            'limit' => $limit,
            'offset' => $offset
        ]);

        return $data;
    }

    /**
     * Update agents data
     *
     * @param LeadsRotationsAgents $agent
     * @param array $data
     * @return LeadsRotationsAgents
     */
    public static function updateAgent(LeadsRotationsAgents $agent, array $data) : LeadsRotationsAgents
    {
        $updateFields = [
            'phone',
            'percent',
            'hits'
        ];

        $agent->saveOrFail($data, $updateFields);

        return $agent;
    }
}
