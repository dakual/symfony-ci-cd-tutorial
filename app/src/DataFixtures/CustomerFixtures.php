<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $customer = new Customer();
            $customer->setName($faker->firstName);
            $customer->setSurname($faker->lastName);
            $customer->setEmail($faker->email);
            $customer->setPhone($faker->phoneNumber);
            $customer->setAddress($this->getReference(AddressFixtures::ADDR_REFERENCE . '-' . rand(0,9)));

            $manager->persist($customer);
        }

        $manager->flush(); 
    }
}
