<?php

declare(strict_types=1);

namespace Kanvas\Guild\Contracts;

use Baka\Contracts\Auth\UserInterface as AuthUserInterface;

interface UserInterface extends AuthUserInterface
{
    public function getCompanies();
}
