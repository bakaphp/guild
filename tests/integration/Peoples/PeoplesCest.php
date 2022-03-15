<?php

declare(strict_types=1);

namespace Kanvas\Guild\Tests\Integration\Peoples;

use IntegrationTester;
use Kanvas\Guild\Peoples\Contacts;
use Kanvas\Guild\Peoples\Models\Peoples as ModelsPeoples;
use Kanvas\Guild\Peoples\Models\PeoplesAddress;
use Kanvas\Guild\Peoples\Peoples;
use Kanvas\Guild\Tests\Support\Models\Users;

class PeoplesCest
{
    public ModelsPeoples $people;

    /**
     * Test create a new people
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testCreatePeople(IntegrationTester $I) : void
    {
        $data = [
            'name' => 'Castillo Choza P.',
            'email' => 'CascasP@mail.com'
        ];

        $people = Peoples::create($data, new Users());

        $this->people = $people;

        $I->assertEquals($data['name'], $people->name);
    }

    /**
     * Get all peoples
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetAllPeoples(IntegrationTester $I) : void
    {
        $peoples = Peoples::getAll(new Users())->toArray();

        $I->assertTrue(isset($peoples[0]['id']));
    }

    /**
     * Test peoples by id
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testGetPeopleById(IntegrationTester $I) : void
    {
        $people = Peoples::getById($this->people->getId(), new Users());

        $I->assertEquals($people->getId(), $this->people->getId());
    }


    /**
     * Update people
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testUpdatePeople(IntegrationTester $I) : void
    {
        $updateData = [
            'name' => 'Casa actualizada',
        ];

        $people = Peoples::update($this->people, $updateData);

        $I->assertEquals($people->name, $this->people->name);
    }

    /**
     * Test add new address for peoples
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testAddPeopleAddress(IntegrationTester $I) : void
    {
        $peopleData = [
            'name' => 'Addreslino Direccionini'
        ];

        $people = Peoples::create($peopleData, new Users());

        $addressData = [
            'address' => 'Los mina huehue #33',
            'address_2' => 'Santo domingo north',
            'city' => 'Santo domingo North',
            'state' => 'Boca chica',
            'zip' => '1165'
        ];

        $address = Peoples::addAddress($people, $addressData, false);
        $I->assertEquals($address->peoples_id, $people->getId());
        $I->assertInstanceOf(PeoplesAddress::class, $address);
    }

    /**
     * Test creation of a new people contact
     *
     * @param IntegrationTester $I
     * @return void
     */
    public function testAddPeoplesContact(IntegrationTester $I) : void
    {
        $peopleData = [
            'name' => 'Contactino Typerino'
        ];

        $contactType = Contacts::createContactType(new Users(), 'Phone', 'phone.png');

        $people = Peoples::create($peopleData, new Users());

        $newContact = Contacts::createNewContact($people, $contactType, "809-111-2344");

        $I->assertEquals($newContact->peoples_id, $people->getId());
    }
}
