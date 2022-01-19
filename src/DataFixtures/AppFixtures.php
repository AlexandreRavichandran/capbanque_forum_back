<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Communication;
use App\Entity\Subcomment;
use App\Entity\Topic;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $userTab = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setMail($faker->email);
            $user->setAddress($faker->address);
            $user->setUsername($faker->userName);
            $user->setRIB("FR".$faker->numberBetween(1000,9999).$faker->numberBetween(1000,9999).$faker->numberBetween(1000,9999).$faker->numberBetween(1000,9999).$faker->numberBetween(1000,9999).$faker->numberBetween(100,999));
            array_push($userTab,$user);
            $manager->persist($user);
        }

        for ($i = 0; $i < 10; $i++) {
            $communication = new Communication();
            $communication->setSender($userTab[$faker->numberBetween(0, 9)]);
            $communication->setRecipient($userTab[$faker->numberBetween(0, 9)]);
            $communication->setCreatedAt(new \DateTimeImmutable());
            $communication->setUpdatedAt(new \DateTimeImmutable());
            $communication->setContent($faker->text);
            $manager->persist($communication);

            for ($i = 0; $i < 10; $i++) {
                $responsecommunication = new Communication();
                $responsecommunication->setSender($userTab[$faker->numberBetween(0, 9)]);
                $responsecommunication->setRecipient($communication->getRecipient());
                $responsecommunication->setContent($faker->text);
                $responsecommunication->setCreatedAt(new \DateTimeImmutable());
                $responsecommunication->setUpdatedAt(new \DateTimeImmutable());
                $responsecommunication->setInResponseOf($communication->getId());
                $manager->persist($responsecommunication);
            }
        }


        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName($faker->word);  
            $manager->persist($category);

            for ($j = 0; $j < 10; $j++) {
                $topic = new Topic();
                $topic->setTitle($faker->sentence(mt_rand(3,8)));  
                $topic->setContent($faker->text); 
                $topic->setCategory($category);
                $topic->setCreatedAt(new \DateTimeImmutable());
                $topic->setUpdatedAt(new \DateTimeImmutable());
                $topic->setUser($userTab[$j]);
                $manager->persist($topic);

                for ($h = 0; $h < 10; $h++) {
                    $comment = new Comment();
                    $comment->setUser($userTab[$faker->numberBetween(0, 9)]);  
                    $comment->setContent($faker->text); 
                    $comment->setTopic($topic);
                    $comment->setCreatedAt(new \DateTimeImmutable());
                    $comment->setUpdatedAt(new \DateTimeImmutable());
                    $manager->persist($comment);
                    

                    for ($l = 0; $l < 10; $l++) {
                        $subcomment = new Subcomment();
                        $subcomment->setUser($userTab[$faker->numberBetween(0, 9)]);  
                        $subcomment->setContent($faker->text); 
                        $subcomment->setComment($comment);
                        $subcomment->setCreatedAt(new \DateTimeImmutable());
                        $subcomment->setUpdatedAt(new \DateTimeImmutable());
                        $manager->persist($subcomment);
                    }
                }

            }

            
        }

        $manager->flush();
    }
}
