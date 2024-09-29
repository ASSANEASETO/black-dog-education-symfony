<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Service;
use App\Entity\Picture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Mapping\Driver\DatabaseDriver;
use Symfony\Component\Validator\Constraints\NotNull;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        // $faker = Factory::create('fr_FR');
        // $faker->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($faker));
        
        for ($i = 0; $i < 3; $i++) {
        $service = (new Service());
        $service->setTitle('title')
                ->setSlug('slug-' . $i)
                ->setSummury('Summury for service')
                ->setDescription('Description');
           


        $manager->persist($service);
        }

        $manager->flush();
    }
}
