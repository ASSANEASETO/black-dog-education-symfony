<?php

namespace App\DataFixtures;

use App\Entity\History;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class HistoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 1; $i++){
            $history= (new History());
            $history->setTitle('title')
                ->setSlug('slug-' .$i)
                ->setSummury('Summury for terms')
                ->setContent('Content for terms');

            $manager->persist($history);
        }

        $manager->flush();
    }
}
