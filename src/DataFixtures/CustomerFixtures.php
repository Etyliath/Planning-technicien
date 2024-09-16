<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $customer = (new Customer())
                ->setName($faker->company())
                ->setPhone($faker->phoneNumber())
                ->setEmail($faker->email())
                ->setAddress($faker->address())
                ->setZipCode($faker->postcode())
                ->setCity($faker->city())
                ->setCreatedAt(\DateTimeImmutable::createFromMutable( $faker->dateTime()))
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable( $faker->dateTime()))
            ;
            $manager->persist($customer);

        }
        $manager->flush();
    }
}
