<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\PriceList;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PriceListFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $faker = Factory::create('fr_FR');
        // $faker->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($faker));
        

        for ($i = 0; $i < 6; $i++) {
            $priceList = new Pricelist();
            $priceList->setTitle('Title ')
                 ->setSlug('slug-' . $i)
                 ->setSummury('Summary for priceList ')
                 ->setDescription('Description of priceList ')
                 ->setPrice(mt_rand(10, 100));
        
            $manager->persist($priceList);
        }

         $manager->flush();
    }
}
