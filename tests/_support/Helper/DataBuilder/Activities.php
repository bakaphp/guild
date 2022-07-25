<?php
namespace Helper\DataBuilder;

use Carbon\Carbon;
use Kanvas\Guild\Activities\Activities as ActivitiesMethods;
use Kanvas\Guild\Activities\Models\Activities as ModelsActivities;
use Kanvas\Guild\Activities\Models\ActivitiesTypes;
use Helper\DataBuilder\Leads as DataBuilderLeads;
use Kanvas\Guild\Activities\Models\ActivitiesStatus;
use Kanvas\Guild\Tests\Support\Models\Users;

class Activities
{
    /**
     * Create a new activity type for testing
     *
     * @return ActivitiesTypes
     */
    public static function createActivitiesType() : ActivitiesTypes
    {
        $name = "Activity Type Name";
        $description = "Description";

        return ActivitiesMethods::createType(new Users(), $name, $description);
    }

    /**
     * Create a new activities status
     *
     * @return ActivitiesStatus
     */
    public static function createActivitiesStatus() : ActivitiesStatus
    {
        $name = "Pending";

        return ActivitiesMethods::createStatus(new Users(), $name);
    }

    /**
     * Create a new Activity type for testing.
     *
     * @return ModelsActivities
     */
    public static function createActivities() : ModelsActivities
    {
        return ActivitiesMethods::create(
            new Users(),
            "Title",
            Carbon::now()->format('Y-m-d'),
            Carbon::now()->addDay()->format('Y-m-d'),
            DataBuilderLeads::createLead(),
            self::createActivitiesType(),
            self::createActivitiesStatus(),
            'Descriptions'
        );
    }
}
