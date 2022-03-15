<?php

declare(strict_types=1);

namespace Kanvas\Guild\Leads;

use Baka\Contracts\Database\ModelInterface;
use Kanvas\Guild\Contracts\UserInterface;
use Kanvas\Guild\Leads\Models\Attempts as ModelAttempts;
use Kanvas\Guild\Leads\Models\Leads;
use Kanvas\Guild\Traits\Searchable as SearchableTrait;

class Attempts
{
    use SearchableTrait;

    /**
     * Set Model for traits.
     *
     * @return ModelInterface
     */
    public static function getModel() : ModelInterface
    {
        return new ModelAttempts();
    }

    /**
     * Create a new lead attempt
     *
     * @param UserInterface $user
     * @param array $data
     * @param Leads|null $lead
     * @return ModelAttempts
     */
    public static function create(UserInterface $user, array $data, ?Leads $lead = null) : ModelAttempts
    {
        $createFields = [
            'request',
            'ip',
            'header',
            'source',
            'public_key',
            'processed'
        ];

        $data['companies_id'] = $user->currentCompanyId();
        $data['leads_id'] = $lead->getId() ?? null;

        $newAttempt = new ModelAttempts();
        $newAttempt->saveOrFail($createFields, $data);

        return $newAttempt;
    }
}
