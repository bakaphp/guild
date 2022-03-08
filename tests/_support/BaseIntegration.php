<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Support;

use Helper\DataBuilder;
use Kanvas\Guild\Tests\Support\Models\Users;

class BaseIntegration
{
    public DataBuilder $dataBuilder;

    public function _before() : void
    {
        $this->dataBuilder = new DataBuilder(new Users());
    }
}
