<?php
namespace Helper\DataBuilder;

use Kanvas\Guild\Rotations\Models\Rotations as ModelsRotations;
use Kanvas\Guild\Rotations\Rotations as RotationsMethods;
use Kanvas\Guild\Tests\Support\Models\Users;

class Rotations
{
    /**
     * Create a new Rotation for testing
     *
     * @return ModelsRotations
     */
    public static function createRotation() : ModelsRotations
    {
        $name = "Rotation No.".rand(1, 100);
        return RotationsMethods::create($name, new Users());
    }
}
