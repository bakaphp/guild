<?php
namespace Helper\DataBuilder;

use Kanvas\Guild\Peoples\Models\Peoples as ModelPeoples;
use Kanvas\Guild\Peoples\Peoples as PeoplesMethods;
use Kanvas\Guild\Tests\Support\Models\Users;

class Peoples
{

    /**
     * Create a new Peoples for testing
     *
     * @return ModelPeoples
     */
    public static function createPeople() : ModelPeoples
    {
        $data = [
            'name' => "Numerologo Paulino.".rand(1, 100)
        ];

        return PeoplesMethods::create($data, new Users());
    }
}
