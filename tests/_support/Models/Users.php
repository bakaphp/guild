<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Support\Models;

use Kanvas\Guild\BaseModel;
use Kanvas\Guild\Contracts\UserInterface;

class Users extends BaseModel implements UserInterface
{
    public function getId() : int
    {
        return $this->id ?? 1;
    }

    public function getCompaniesId() : int
    {
        return 1;
    }
}
