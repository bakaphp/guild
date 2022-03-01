<?php

declare(strict_types=1);

namespace Kanvas\Guild\Peoples;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Peoples\Models\Peoples as ModelsPeoples;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;
use Phalcon\Utils\Slug;

class Peoples
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ModelsPeoples();
    }

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

        $organization->saveOrFail($data, $updateFields);

        return $organization;
    }
}