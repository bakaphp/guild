<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Support\Models;

use Baka\Contracts\Auth\UserInterface;
use Kanvas\Guild\BaseModel;

class Users extends BaseModel implements UserInterface
{
    public function getId() : int
    {
        return $this->id ?? 1;
    }
}
