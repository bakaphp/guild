<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Pipelines;

use IntegrationTester;
use Kanvas\Guild\Rotations\Models\Rotations as ModelsRotations;
use Kanvas\Guild\Rotations\Rotations;
use Kanvas\Guild\Tests\Support\Models\Users;

class RotationsCest
{
    public ModelsRotations $rotations;

    /**
     * Test create a new rotations
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreateRotation(IntegrationTester $I) : void
    {
        $name = "People Groups";

        $rotations = Rotations::create($name, new Users());

        $this->rotations = $rotations;

        $I->assertEquals($name, $rotations->name);
    }

    /**
     * Get all pipelines
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAllRotations(IntegrationTester $I) : void
    {
        $rotations = Rotations::getAll(new Users())->toArray();

        $I->assertTrue(isset($rotations[0]['id']));
    }

    /**
     * Test get rotation by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetRotationById(IntegrationTester $I) : void
    {
        $rotation = Rotations::getById($this->rotations->getId(), new Users());

        $I->assertEquals($rotation->getId(), $this->rotations->getId());
    }


    /**
     * Update rotation
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testUpdateRotation(IntegrationTester $I) : void
    {
        $rotation = Rotations::update($this->rotations, "Updated Rotation");

        $I->assertEquals($rotation->name, $this->rotations->name);
    }

    /**
     * Get rotation by name
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetRotationByName(IntegrationTester $I) : void
    {
        $rotation = Rotations::getByName($this->rotations->name, new Users());
        $I->assertEquals($rotation->name, $this->rotations->name);
    }
}
