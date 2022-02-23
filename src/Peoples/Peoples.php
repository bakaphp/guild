<?php

declare(strict_types=1);

namespace Kanvas\Guild\Peoples;

use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Peoples\Models\Peoples as ModelsPeoples;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Utils\Slug;

class Peoples
{
    /**
     * Create a new organization
     *
     * @param array $data
     * @param UserInterface $user
     * @return ModelsPeoples
     */
    public static function create(array $data, UserInterface $user) : ModelsPeoples
    {
        $createFields = [
            'name',
            'users_id',
            'companies_id'
        ];

        $data['users_id'] = $user->getId();
        $data['companies_id'] = $user->currentCompanyId();
        $organization = new ModelsPeoples();
        $organization->saveOrFail($data, $createFields);

        return $organization;
    }

    /**
     * Get all organizations associated to a company
     *
     * @param integer $page
     * @param integer $limit
     * @return ResultsetInterface
     */
    public static function getAll(UserInterface $user, int $page = 1, int $limit = 10) : ResultsetInterface
    {
        $offset = ($page - 1) * $limit;

        $organizations = ModelsPeoples::find([
            'conditions' => 'companies_id = :company_id: AND is_deleted = 0',
            'bind' => [
                'company_id' => $user->currentCompanyId()
            ],
            'limit' => $limit,
            'offset' => $offset
        ]);

        return $organizations;
    }

    /**
     * Get a organization by its id
     *
     * @param integer $id
     * @return ModelsPeoples
     */
    public static function getById(int $id, UserInterface $user) : ModelsPeoples
    {
        return ModelsPeoples::findFirstOrFail(
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
     * Get organization by name
     *
     * @param string $name
     * @param UserInterface $user
     * @return ModelsPeoples
     */
    public static function getByName(string $name, UserInterface $user) : ModelsPeoples
    {
        return ModelsPeoples::findFirstOrFail(
            [
                'conditions' => 'slug = :slug: AND companies_id = :companies_id: AND is_deleted = 0',
                'bind' => [
                    'slug' => Slug::generate($name),
                    'companies_id' => $user->currentCompanyId()
                ]
            ]
        );
    }

    /**
     * Update organization
     *
     * @param ModelsPeoples $organization
     * @param array $data
     * @return ModelsPeoples
     */
    public static function update(ModelsPeoples $organization, array $data) : ModelsPeoples
    {
        $updateFields = [
            'name',
        ];

        $data['slug'] = Slug::generate($data['name']);
        $organization->saveOrFail($data, $updateFields);

        return $organization;
    }
}
