<?php

namespace App\DataFixtures;

use App\Entity\Terms;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TermsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 1; $i++){
            $term = new Terms();
            $term->setTitle('title')
            ->setSlug('slug-' . $i)
            ->setSummury('Summary for terms ')
            ->setContent('Content for terms ');
                
            $manager->persist($term);
        }

        $manager->flush();
    }
}
