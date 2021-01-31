<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Comment;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadUser($manager);
        $this->loadPost($manager);
      //  $this->loadUser($manager);


    }
    /**
     * Fct add Post
     */
    private function loadPost(ObjectManager $manager){
            $post = new Post();
            $post->setTitle("My Title ");
            $post->setSlug("My-Title-");
            $post->setPublished(new \DateTime());
            $post->setContent("My Title ");
            $user = $this->getReference("admin_user");
            $post->setAutor($user);
            $manager->persist( $post );
            $manager->flush();

    }
     /**
     * Fct add User
     */
    private function loadUser(ObjectManager $manager){
        $user = new User();
        $user->setUsername("Ya27cine");
        $user->setEmail("yacinemosta910@gmail.com");
        $user->setName("Khelifa Yassine");
        $user->setPassword("PassW@rd");

        $this->setReference("admin_user", $user);

        $manager->persist( $user );
        $manager->flush();

    }

    /**
     * Fct add Comment
     */
    private function loadComment(ObjectManager $manager){
      
    }
}
