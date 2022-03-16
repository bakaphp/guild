<?php

declare(strict_types=1);

namespace Kanvas\Guild\Leads\Models;

use Kanvas\Guild\BaseModel;

class Attempts extends BaseModel
{
    public int $companies_id;
    public ?int $leads_id = null;
    public string $request;
    public string $ip;
    public string $header;
    public string $source;
    public string $public_key;
    public int $processed;

    public function initialize()
    {
        parent::initialize();
        $this->setSource('leads_attempt');

        $this->belongsTo(
            'leads_id',
            Leads::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'lead',
            ]
        );
    }

    /**
     * Add a new lead to the attempt
     *
     * @param Leads $lead
     * @return Attempts
     */
    public function addLead(Leads $lead) : Attempts
    {
        $this->leads_id = $lead->getId();
        $this->saveOrFail();

        return $this;
    }


    /**
     * Set processed status for the attempt
     *
     * @param boolean $processedStatus
     * @return Attempts
     */
    public function isProcessed(bool $processedStatus) : Attempts
    {
        $this->processed = (int) $processedStatus;
        $this->saveOrFail();

        return $this;
    }
}
