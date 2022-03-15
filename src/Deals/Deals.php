<?php

declare(strict_types=1);

namespace Kanvas\Guild\Deals;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Deals\Models\Deals as ModelsDeals;
use Kanvas\Guild\Leads\Models\Leads;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;

class Deals
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ModelsDeals();
    }

    /**
     * Create a new deal
     *
     * @param UserInterface $user
     * @param array $data
     * @param Leads|null $lead
     * @return ModelsDeals
     */
    public static function create(UserInterface $user, Leads $lead) : ModelsDeals
    {
        $deal = new ModelsDeals();
        $deal->leads_id = $lead->getId();
        $deal->users_id = $lead->users_id;
        $deal->companies_id = $lead->companies_id;
        $deal->owner_id = $lead->leads_owner_id;
        $deal->status_id = $lead->leads_status_id;
        $deal->people_id = $lead->people_id;
        $deal->pipeline_stage_id = $lead->pipeline_stage_id;
        $deal->organization_id = $lead->organization_id;
        $deal->title = $lead->title;
        $deal->description = $lead->description;
        $deal->saveOrFail();

        return $deal;
    }


    /**
     * Update deal data
     *
     * @param ModelsDeals $deal
     * @param array $data
     * @return ModelsDeals
     */
    public static function update(ModelsDeals $deal, array $data) : ModelsDeals
    {
        $updateFields = [
            'title',
            'description',
            'owner_id',
            'status_id',
            'pipeline_stage_id',
            'organization_id'
        ];

        $deal->saveOrFail($data, $updateFields);

        return $deal;
    }
}
