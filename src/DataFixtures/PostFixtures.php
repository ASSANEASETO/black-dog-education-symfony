<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; $i++) {
            $post = new Post();
            $post->setTitle('Title ')
                 ->setSlug('slug-' . $i)
                 ->setSummary('Summary for post ') 
                 ->setContent('Content for post ')
                 ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($post);
        }

    
        $manager->flush();
    }

}
