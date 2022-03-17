<?php
namespace Helper\DataBuilder;

use Helper\DataBuilder\Organizations as DataBuilderOrganizations;
use Helper\DataBuilder\Peoples as DataBuilderPeoples;
use Helper\DataBuilder\Pipelines as DataBuilderPipelines;
use Helper\DataBuilder\Receivers as DataBuilderReceivers;
use Helper\DataBuilder\Rotations as DataBuilderRotations;
use Kanvas\Guild\Leads\Leads as LeadsMethods;
use Kanvas\Guild\Leads\LeadsTypes;
use Kanvas\Guild\Leads\Models\Leads as ModelsLeads;
use Kanvas\Guild\Leads\Models\Source;
use Kanvas\Guild\Leads\Models\Status;
use Kanvas\Guild\Leads\Models\Types as ModelLeadTypes;
use Kanvas\Guild\Rotations\Agents;
use Kanvas\Guild\Tests\Support\Models\Users;

class Leads
{

    /**
     * Create new Leads for testing
     *
     * @return ModelsLeads
     */
    public static function createLead() : ModelsLeads
    {
        $rotation = DataBuilderRotations::createRotation();
        $receiver = DataBuilderReceivers::createReceiver();
        $agent = Agents::create($rotation, new Users(), $receiver, 1.0);

        $lead = LeadsMethods::create(
            new Users(),
            "Lead No.". rand(1, 130),
            DataBuilderPipelines::createPipelineStage(),
            $agent,
            DataBuilderPeoples::createPeople(),
            DataBuilderOrganizations::createOrganization(),
            self::createLeadType(),
            self::createLeadStatus(),
            self::createLeadSource(),
            false,
            "Test description"
        );

        return $lead;
    }

    /**
     * Create lead type for testing
     *
     * @return ModelLeadTypes
     */
    public static function createLeadType() : ModelLeadTypes
    {
        $name = "Type No.".rand();
        $description = "Description about this so can be join maybe lol";

        $newType = LeadsTypes::create(new Users(), $name, $description);
        return $newType;
    }

    /**
     * Create lead status for tests
     *
     * @return Status
     */
    public static function createLeadStatus() : Status
    {
        $status = new Status();
        $status->name = "Pending";
        $status->saveOrFail();

        return $status;
    }

    /**
     * Create lead source for testing
     *
     * @return Source
     */
    public static function createLeadSource() : Source
    {
        $user = new Users();
        $status = new Source();
        $status->name = "Pending";
        $status->companies_id = $user->currentCompanyId();
        $status->saveOrFail();

        return $status;
    }
}
