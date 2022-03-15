<?php
namespace Helper;

use Helper\DataBuilder\Leads as DataBuilderLeads;
use Helper\DataBuilder\Organizations as DataBuilderOrganizations;
use Helper\DataBuilder\Peoples as DataBuilderPeoples;
use Helper\DataBuilder\Pipelines as DataBuilderPipelines;
use Helper\DataBuilder\Receivers as DataBuilderReceivers;
use Helper\DataBuilder\Rotations as DataBuilderRotations;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Leads\Models\Leads as ModelsLeads;
use Kanvas\Guild\Leads\Models\Receivers as ModelsReceivers;
use Kanvas\Guild\Leads\Models\Source;
use Kanvas\Guild\Leads\Models\Status;
use Kanvas\Guild\Leads\Models\Types as ModelLeadTypes;
use Kanvas\Guild\Organizations\Models\Organizations as ModelOrganizations;
use Kanvas\Guild\Peoples\Models\Peoples as ModelPeoples;
use Kanvas\Guild\Pipelines\Models\Pipelines as ModelsPipelines;
use Kanvas\Guild\Pipelines\Models\Stages;
use Kanvas\Guild\Rotations\Models\Rotations as ModelsRotations;
use Kanvas\Guild\Tests\Support\Models\Users;

class DataBuilder
{
    public UserInterface $user;

    /**
     * Set user interface to use methods
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Create a new Pipeline for testing
     *
     * @return ModelsPipelines
     */
    public function createPipeline() : ModelsPipelines
    {
        return DataBuilderPipelines::createPipeline(new Users());
    }

    /**
     * Create a new pipeline Stage for testing
     *
     * @return Stages
     */
    public function createPipelineStage() : Stages
    {
        return DataBuilderPipelines::createPipelineStage();
    }

    /**
     * Create a new receiver for testing
     *
     * @return ModelsReceivers
     */
    public function createReceiver() : ModelsReceivers
    {
        return DataBuilderReceivers::createReceiver();
    }

    /**
     * Create a new Rotation for testing
     *
     * @return ModelsRotations
     */
    public function createRotation() : ModelsRotations
    {
        return DataBuilderRotations::createRotation();
    }

    /**
     * Create a new Organization for testing
     *
     * @return ModelOrganizations
     */
    public function createOrganization() : ModelOrganizations
    {
        return DataBuilderOrganizations::createOrganization();
    }

    /**
     * Create a new Peoples for testing
     *
     * @return ModelPeoples
     */
    public function createPeople() : ModelPeoples
    {
        return DataBuilderPeoples::createPeople();
    }

    /**
     * Create new lead for testing
     *
     * @return ModelsLeads
     */
    public function createLead() : ModelsLeads
    {
        return DataBuilderLeads::createLead();
    }

    /**
     * Create lead type for testing
     *
     * @return ModelLeadTypes
     */
    public function createLeadType() : ModelLeadTypes
    {
        return DataBuilderLeads::createLeadType();
    }

    /**
     * Create lead status for tests
     *
     * @return Status
     */
    public function createLeadStatus() : Status
    {
        return DataBuilderLeads::createLeadStatus();
    }

    /**
     * Create lead source for testing
     *
     * @return Source
     */
    public function createLeadSource() : Source
    {
        return DataBuilderLeads::createLeadSource();
    }
}
