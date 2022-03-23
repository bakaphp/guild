<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Leads;

use IntegrationTester;
use Kanvas\Guild\Leads\Models\Receivers as ModelsReceivers;
use Kanvas\Guild\Leads\Receivers;
use Kanvas\Guild\Tests\Support\BaseIntegration;
use Kanvas\Guild\Tests\Support\Models\Users;

class LeadsReceiversCest extends BaseIntegration
{
    public ModelsReceivers $receiver;

    /**
     * Test create of a new Receiver
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreateLeadReceiver(IntegrationTester $I) : void
    {
        $receiver = Receivers::create(
            new Users(),
            'Receiver in Testing',
            $this->dataBuilder->createRotation(),
            'Source name development',
            true
        );

        $this->receiver = $receiver;

        $I->assertInstanceOf(ModelsReceivers::class, $receiver);
        $I->assertNotNull($receiver->getId());
    }

    /**
     * Test update receiver
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testUpdateLeadReceiver(IntegrationTester $I) : void
    {
        $rotation = $this->dataBuilder->createRotation();
        $receiver = $this->dataBuilder->createReceiver();

        $data = [
            'name' => 'Receiver updated name',
            'source_name' => 'New source name'
        ];

        $updateReceiver = Receivers::update($receiver, $data, $rotation);
        
        $I->assertEquals($data['name'], $updateReceiver->name);
        $I->assertEquals($rotation->getId(), $updateReceiver->rotations_id);
    }

    /**
     * Test get all receiver
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAllReceivers(IntegrationTester $I) : void
    {
        $this->dataBuilder->createReceiver();

        $receiver = Receivers::getAll(new Users())->toArray();

        $I->assertTrue(isset($receiver[0]['id']));
    }

    /**
     * Test get receiver by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetReceiverById(IntegrationTester $I) : void
    {
        $newReceivers = $this->dataBuilder->createReceiver();
        $receiver = Receivers::getById($newReceivers->getId(), new Users());

        $I->assertEquals($receiver->getId(), $newReceivers->getId());
    }
}
