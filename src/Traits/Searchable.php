<?php

declare(strict_types=1);

namespace Kanvas\Guild\Traits;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Phalcon\Mvc\Model\ResultsetInterface;

trait Searchable
{
    abstract public static function getModel() : ModelInterface;

    /**
     * Get all the data from a domain model paginated.
     *
     * @param UserInterface $user
     * @param integer $page
     * @param integer $limit
     * @return ResultsetInterface
     */
    public static function getAll(UserInterface $user, int $page = 1, int $limit = 10) : ResultsetInterface
    {
        $offset = ($page - 1) * $limit;
        $model = self::getModel();

        $data = $model::find([
            'conditions' => 'companies_id = :company_id: AND is_deleted = 0',
            'bind' => [
                'company_id' => $user->currentCompanyId()
            ],
            'limit' => $limit,
            'offset' => $offset
        ]);

        return $data;
    }

    /**
     * Get a domain data by its id
     *
     * @param integer $id
     * @param UserInterface $user
     * @return ModelInterface
     */
    public static function getById(int $id, UserInterface $user) : ModelInterface
    {
        $model = self::getModel();

        return $model::findFirstOrFail(
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
     *  Get a domain data by its uuid.
     *
     * @param string $uui
     * @param UserInterface $user
     *
     * @return ModelInterface
     */
    public static function getByUuid(string $uuid, UserInterface $user) : ModelInterface
    {
        $model = self::getModel();

        return $model::findFirstOrFail([
            'conditions' => 'uuid = :uuid: 
                            AND companies_id = :companies_id: AND is_deleted = 0',
            'bind' => [
                'uuid' => $uuid,
                'companies_id' => $user->currentCompanyId(),
            ]
        ]);
    }
}
