<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Comment;

class AppFixtures extends Fixture
{
    private $userPass;
    private $faker;

    function __construct(UserPasswordEncoderInterface $userPass)
    {
        $this->userPass = $userPass;
        $this->faker = Factory::create();
    }
    public function load(ObjectManager $manager)
    {
        $this->loadUser($manager);
        $this->loadPost($manager);
        $this->loadComment($manager);


    }
    /**
     * Fct add Post
     */
    private function loadPost(ObjectManager $manager){
        for ($i=0; $i < 100; $i++) { 
            $post = new Post();
            $post->setTitle($this->faker->sentence());
            $post->setSlug($this->faker->slug());
            $post->setPublished(new \DateTime());
            $post->setContent($this->faker->realText());
            $user = $this->getReference("admin_user_". rand(0, 9));
            $post->setAutor($user);
             
            $this->addReference("post_".$i, $post);

            $manager->persist( $post );
        }
            
            $manager->flush();
    }
     /**
     * Fct add User
     */
    private function loadUser(ObjectManager $manager){
        for ($i=0; $i < 10; $i++) { 
            $user = new User();
            $user->setUsername( $this->faker->userName);
            $user->setEmail($this->faker->email);
            $user->setName($this->faker->name);
            $user->setPassword($this->userPass->encodePassword($user, "passw@rd"));

            $this->setReference("admin_user_".$i, $user);

            $manager->persist( $user );
        }
       
        $manager->flush();

    }

    /**
     * Fct add Comment
     */
    private function loadComment(ObjectManager $manager){
        for ($i=0; $i < 100; $i++) { 
            $comment = new Comment();
            $comment->setContent( $this->faker->realText());
            $comment->setPublished( new \DateTime());


            $user  = $this->getReference("admin_user_". rand(0, 9));
            $post  = $this->getReference("post_". rand(0, 99));

            $comment->setAutor( $user );
            $comment->setPost( $post );

            $manager->persist( $comment );
        }
       
        $manager->flush();
    }
}
