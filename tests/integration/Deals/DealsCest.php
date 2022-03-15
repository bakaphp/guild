<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Pipelines;

use IntegrationTester;
use Kanvas\Guild\Deals\Deals;
use Kanvas\Guild\Deals\Models\Deals as ModelsDeals;
use Kanvas\Guild\Tests\Support\BaseIntegration;
use Kanvas\Guild\Tests\Support\Models\Users;

class DealsCest extends BaseIntegration
{
    /**
     * Test create deal
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreateDeal(IntegrationTester $I) : void
    {
        $lead = $this->dataBuilder->createLead();

        $deal = Deals::create(new Users(), $lead);

        $I->assertInstanceOf(ModelsDeals::class, $deal);
        $I->assertNotNull($deal->getId());
        $I->assertEquals($lead->getId(), $deal->leads_id);
    }

    /**
     * Test edit deal
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testUpdateDeal(IntegrationTester $I) : void
    {
        $lead = $this->dataBuilder->createLead();
        $deal = Deals::create(new Users(), $lead);

        $data = [
            'title' => "New Title No.".rand(1, 100),
            'description' => "New Description". rand(1, 100)
        ];

        $dealEdited = Deals::update($deal, $data);
        $I->assertEquals($data['title'], $dealEdited->title);
    }
}
