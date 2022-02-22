<?php

declare(strict_types=1);

namespace Kanvas\Guild\Organizations;

use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Organizations\Models\Organizations as ModelsOrganizations;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Utils\Slug;

class Organizations
{
    /**
     * Create a new organization
     *
     * @param array $data
     * @param UserInterface $user
     * @return ModelsOrganizations
     */
    public static function create(array $data, UserInterface $user) : ModelsOrganizations
    {
        $createFields = [
            'name',
            'slug',
            'address',
            'users_id',
            'companies_id'
        ];

        $data['users_id'] = $user->getId();
        $data['companies_id'] = $user->currentCompanyId();
        $data['slug'] = Slug::generate($data['name']);
        $organization = new ModelsOrganizations();
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
    public static function getAll(UserInterface $user, $page = 1, $limit = 10) : ResultsetInterface
    {
        $offset = ($page - 1) * $limit;

        $organizations = ModelsOrganizations::find([
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
     * @return ModelsOrganizations
     */
    public static function getById(int $id, UserInterface $user) : ModelsOrganizations
    {
        return ModelsOrganizations::findFirstOrFail(
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
     * @return ModelsOrganizations
     */
    public static function getByName(string $name, UserInterface $user) : ModelsOrganizations
    {
        return ModelsOrganizations::findFirstOrFail(
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
     * @param ModelsOrganizations $organization
     * @param array $data
     * @return ModelsOrganizations
     */
    public static function update(ModelsOrganizations $organization, array $data) : ModelsOrganizations
    {
        $updateFields = [
            'name',
            'address'
        ];

        $data['slug'] = Slug::generate($data['name']);
        $organization->saveOrFail($data, $updateFields);

        return $organization;
    }
}
