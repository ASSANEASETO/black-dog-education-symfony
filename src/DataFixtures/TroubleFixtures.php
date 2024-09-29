<?php

namespace App\DataFixtures;

use App\Entity\Trouble;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TroubleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 2; $i++) {
            $trouble = new Trouble();
            $trouble->setTitle('title')
                    ->setSlug('slug-' .$i)
                    ->setSummury('Summury for terms')
                    ->setContent('Content for terms');

            $manager->persist($trouble);
        }

        $manager->flush();
    }
}
