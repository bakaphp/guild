<?php
namespace Helper\DataBuilder;

use Kanvas\Guild\Organizations\Models\Organizations as ModelOrganizations;
use Kanvas\Guild\Organizations\Organizations as OrganizationsMethods;
use Kanvas\Guild\Tests\Support\Models\Users;

class Organizations
{
    /**
     * Create a new Organization for testing
     *
     * @return ModelOrganizations
     */
    public static function createOrganization() : ModelOrganizations
    {
        $data = [
            'name' => "Organization No.".rand(1, 100),
            'address' => 'Lomina 22, #44, Santo domingo Arriba'
        ];

        return OrganizationsMethods::create($data, new Users());
    }
}
