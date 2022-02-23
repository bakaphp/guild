<?php

declare(strict_types=1);

namespace Kanvas\Guild\Traits;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Phalcon\Mvc\Model\ResultsetInterface;

trait Crudable
{
    /**
     * Get all the data from a domain model paginated.
     *
     * @param ModelInterface $model
     * @param UserInterface $user
     * @param integer $page
     * @param integer $limit
     * @return ResultsetInterface
     */
    protected static function getAllData(ModelInterface $model, UserInterface $user, int $page = 1, int $limit = 10) : ResultsetInterface
    {
        $offset = ($page - 1) * $limit;

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
}
