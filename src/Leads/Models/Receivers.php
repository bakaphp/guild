<?php

declare(strict_types=1);

namespace Kanvas\Guild\Leads\Models;

use Baka\Database\Behaviors\Uuid;
use Kanvas\Guild\BaseModel;
use Kanvas\Guild\Rotations\Models\Rotations;

class Receivers extends BaseModel
{
    public string $uuid;
    public int $companies_id;
    public ?int $companies_branches_id = null;
    public string $name;
    public int $users_id;
    public int $agents_id;
    public int $rotations_id;
    public string $source_name;
    public int $total_leads = 0;
    public int $is_default = 0;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('leads_receivers');

        $this->addBehavior(
            new Uuid()
        );

        $this->belongsTo(
            'rotations_id',
            Rotations::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'rotation',
            ]
        );
    }


    /**
     * Change default status for the receiver
     *
     * @param boolean $isDefault
     * @return Receivers
     */
    public function setDefault(bool $isDefault) : Receivers
    {
        $this->is_default = $isDefault;
        $this->saveOrFail();

        return $this;
    }

    /**
     * Increment the total lead by one.
     *
     * @return integer
     */
    public function incrementTotalLeads() : int
    {
        $this->total_leads = ++$this->total_leads;
        return $this->total_leads;
    }


    /**
     * Decrease total leads by one.
     *
     * @return integer
     */
    public function decreaseTotalLeads() : int
    {
        $this->total_leads = --$this->total_leads;
        return $this->total_leads;
    }
}
