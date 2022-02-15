<?php

declare(strict_types=1);

namespace Kanvas\Guild\Contracts;

interface UserInterface
{
    public function getId();
    public function getCompanies();
}
