<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Pipelines;

use IntegrationTester;
use Kanvas\Guild\Rotations\Models\Rotations;
use Kanvas\Guild\Leads\Models\Receivers as ModelsReceivers;
use Kanvas\Guild\Leads\Receivers;
use Kanvas\Guild\Tests\Support\Models\Users;

class LeadsReceiversCest
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
            Rotations::findFirst(),
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
        $rotation = Rotations::findFirst([
            'conditions' => 'id != :old_rotation: AND is_deleted = 0',
            'bind' => [
                'old_rotation' => $this->receiver->rotations_id
            ]
        ]);

        $data = [
            'name' => 'Receiver updated name',
            'source_name' => 'New source name'
        ];

        $updateReceiver = Receivers::update($this->receiver, $data, $rotation);
        
        $I->assertEquals($data['name'], $updateReceiver->name);
        $I->assertEquals($rotation->getId(), $updateReceiver->rotations_id);
    }
}
