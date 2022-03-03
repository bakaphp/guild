<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Pipelines;

use IntegrationTester;
use Kanvas\Guild\Peoples\Contacts;
use Kanvas\Guild\Peoples\Models\ContactsTypes;
use Kanvas\Guild\Peoples\Models\Peoples as ModelsPeoples;
use Kanvas\Guild\Peoples\Models\PeoplesAddress;
use Kanvas\Guild\Peoples\Peoples;
use Kanvas\Guild\Tests\Support\Models\Users;

class ContactsCest
{
    public ContactsTypes $contactType;

    /**
     * Test to create a new contact type
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreateContactType(IntegrationTester $I) : void
    {
        $contactType = Contacts::createContactType(new Users(), 'Phone', 'phone.png');

        $this->contactType = $contactType;

        $I->assertInstanceOf(ContactsTypes::class, $contactType);
        $I->assertNotNull($contactType->getId());
    }

    /**
     * Test get contact type by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetContactTypeById(IntegrationTester $I) : void
    {
        $contactType = Contacts::getById($this->contactType->getId(), new Users());
        
        $I->assertInstanceOf(ContactsTypes::class, $contactType);
        $I->assertEquals($this->contactType->getId(), $contactType->getId());
    }
}
