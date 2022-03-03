<?php

declare(strict_types=1);

namespace Kanvas\Guild\Organizations;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Organizations\Models\Organizations as ModelsOrganizations;
use Kanvas\Guild\Organizations\Models\OrganizationsPeoples;
use Kanvas\Guild\Peoples\Models\Peoples;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;
use Phalcon\Utils\Slug;

class Organizations
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ModelsOrganizations();
    }

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
            'address',
            'users_id',
            'companies_id'
        ];

        $data['users_id'] = $user->getId();
        $data['companies_id'] = $user->currentCompanyId();
        $organization = new ModelsOrganizations();
        $organization->saveOrFail($data, $createFields);

        return $organization;
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

        $organization->saveOrFail($data, $updateFields);

        return $organization;
    }

    /**
     * Add people to an organization
     *
     * @param ModelsOrganizations $organization
     * @param Peoples $people
     * @return OrganizationsPeoples
     */
    public static function addPeople(ModelsOrganizations $organization, Peoples $people) : OrganizationsPeoples
    {
        $organizationPeople = OrganizationsPeoples::findFirstOrCreate(
            [
                'conditions' => 'organizations_id = :organizations_id: AND peoples_id = :peoples_id: AND is_deleted = 0',
                'bind' => [
                    'organizations_id' => $organization->getId(),
                    'peoples_id' => $people->getId()
                ]
            ],
            [
                'organizations_id' => $organization->getId(),
                'peoples_id' => $people->getId(),
            ]
        );

        return $organizationPeople;
    }
}
