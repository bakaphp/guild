<?php
namespace Helper\DataBuilder;

use Kanvas\Guild\Leads\Models\Receivers as ModelsReceivers;
use Kanvas\Guild\Leads\Receivers as ReceiversMethods;
use Kanvas\Guild\Tests\Support\Models\Users;

class Receivers
{
    /**
     * Create a new receiver for testing
     *
     * @return ModelsReceivers
     */
    public static function createReceiver() : ModelsReceivers
    {
        $name = "Receiver No.".rand(1, 100);

        return ReceiversMethods::create(new Users(), $name, Rotations::createRotation(), 'Walkin');
    }
}
