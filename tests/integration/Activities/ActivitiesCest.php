<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Deals;

use Carbon\Carbon;
use IntegrationTester;
use Kanvas\Guild\Activities\Activities;
use Kanvas\Guild\Activities\Models\Activities as ModelsActivities;
use Kanvas\Guild\Activities\Models\ActivitiesStatus;
use Kanvas\Guild\Activities\Models\ActivitiesTypes;
use Kanvas\Guild\Activities\Status;
use Kanvas\Guild\Tests\Support\BaseIntegration;
use Kanvas\Guild\Tests\Support\Models\Users;

class ActivitiesCest extends BaseIntegration
{
    /**
     * Test create deal
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreateActivities(IntegrationTester $I) : void
    {
        $lead = $this->dataBuilder->createLead();

        $activities = Activities::create(
            new Users(),
            "Title",
            Carbon::now()->format('Y-m-d'),
            Carbon::now()->addDay()->format('Y-m-d'),
            $lead,
            $this->dataBuilder->createActivitiesType(),
            $this->dataBuilder->createActivitiesStatus(),
            'Activities Status'
        );

        $I->assertInstanceOf(ModelsActivities::class, $activities);
        $I->assertNotNull($activities->getId());
        $I->assertEquals($lead->getId(), $activities->leads_id);
    }

    /**
     * Test edit activity
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testUpdateActivity(IntegrationTester $I) : void
    {
        $activity = $this->dataBuilder->createActivities();
        $startDate = Carbon::now()->addDay()->format('Y-m-d');

        $data = [
            'title' => "New Title No.".rand(1, 100),
            'description' => "New Description". rand(1, 100),
            'start_date' => $startDate
        ];

        $activityEdited = Activities::update($activity, $data);
        $I->assertEquals($data['title'], $activityEdited->title);
        $I->assertEquals($data['start_date'], $activityEdited->start_date);
    }

    /**
     * Test create types
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testActivityTypeCreate(IntegrationTester $I) : void
    {
        $name = "Activity Type Name";
        $description = "Description";

        $type = Activities::createType(new Users(), $name, $description);

        $I->assertInstanceOf(ActivitiesTypes::class, $type);
        $I->assertNotNull($type->getId());
    }

    /**
     * Test creation of activities status
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testActivityStatusCreate(IntegrationTester $I) : void
    {
        $name = "Overdue";

        $status = Status::createStatus(new Users(), $name, true);

        $I->assertInstanceOf(ActivitiesStatus::class, $status);
        $I->assertNotNull($status->getId());
    }

    /**
     * Test get all activities
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAllActivities(IntegrationTester $I) : void
    {
        $this->dataBuilder->createActivities();

        $activities = Activities::getAll(new Users())->toArray();

        $I->assertTrue(isset($activities[0]['id']));
    }

    /**
     * Test get activity by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetActivityById(IntegrationTester $I) : void
    {
        $newActivity = $this->dataBuilder->createActivities();
        $activity = Activities::getById($newActivity->getId(), new Users());

        $I->assertEquals($activity->getId(), $newActivity->getId());
    }
}
