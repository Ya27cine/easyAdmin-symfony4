<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i=0; $i < 20; $i++) { 
            $post = new Post();
            $post->setTitle("My Title ".$i);
            $post->setSlug("My-Title-".$i);
            $post->setPublished(new \DateTime());
            $post->setContent("My Title ".$i);
            $post->setAutor("User ".$i);

            $manager->persist( $post );
        }

        $manager->flush();
    }
}
