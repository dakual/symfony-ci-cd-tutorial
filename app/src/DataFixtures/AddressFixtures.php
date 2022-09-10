<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AddressFixtures extends Fixture
{
    public const ADDR_REFERENCE = 'address';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $address = new Address();
            $address->setAddress($faker->address);
            $address->setZipcode((int)$faker->postcode);
            $address->setCity($faker->city);

            $manager->persist($address);
            $this->addReference(self::ADDR_REFERENCE . '-' . $i, $address);
        }

        $manager->flush(); 
    }
}
