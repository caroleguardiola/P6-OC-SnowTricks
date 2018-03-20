<?php

namespace ST\TricksBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ST\TricksBundle\Entity\Category;
use ST\TricksBundle\Entity\Trick;
use ST\TricksBundle\Entity\Thumbnail;
use ST\TricksBundle\Entity\Image;
use ST\TricksBundle\Entity\Video;
use ST\TricksBundle\Entity\Comment;
use ST\UserBundle\Entity\User;
use ST\UserBundle\Entity\Photo;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadFixtures implements FixtureInterface, ContainerAwareInterface 
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        //Catégories
        $category1 = new Category;
        $category1->setName('Grab'); // Liste des noms de catégorie à ajouter
        $manager->persist($category1);

        $category2 = new Category;
        $category2->setName('Rotation'); // Liste des noms de catégorie à ajouter
        $manager->persist($category2);

        //Tricks
        $trick1 = new Trick;
        $trick1->setName('Indy');
        $trick1->setDescription('Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.');
        $trick1->setCategory($category1);
        $trick1->setDateCreation(new \DateTime('now'));
        $manager->persist($trick1);

        $trick2 = new Trick;
        $trick2->setName('Japan');
        $trick2->setDescription('Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.');
        $trick2->setCategory($category1);
        $trick2->setDateCreation(new \DateTime('now'));
        $manager->persist($trick2);

        $trick3 = new Trick;
        $trick3->setName('Tail Grab');
        $trick3->setDescription('Saisie de la partie arrière de la planche, avec la main arrière.');
        $trick3->setCategory($category1);
        $trick3->setDateCreation(new \DateTime('now'));
        $manager->persist($trick3);

        $trick4 = new Trick;
        $trick4->setName('Nose Grab');
        $trick4->setDescription('Saisie de la partie avant de la planche, avec la main avant.');
        $trick4->setCategory($category1);
        $trick4->setDateCreation(new \DateTime('now'));
        $manager->persist($trick4);

        $trick5 = new Trick;
        $trick5->setName('Truck driver');
        $trick5->setDescription('Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture).');
        $trick5->setCategory($category1);
        $trick5->setDateCreation(new \DateTime('now'));
        $manager->persist($trick5);

        $trick6 = new Trick;
        $trick6->setName('Mute');
        $trick6->setDescription('Saisie de la partie avant de la planche, avec la main avant.');
        $trick6->setCategory($category1);
        $trick6->setDateCreation(new \DateTime('now'));
        $manager->persist($trick6);

        $trick7 = new Trick;
        $trick7->setName('Seat Belt');
        $trick7->setDescription('Saisie du carre frontside à l\'arrière avec la main avant.');
        $trick7->setCategory($category1);
        $trick7->setDateCreation(new \DateTime('now'));
        $manager->persist($trick7);

        $trick8 = new Trick;
        $trick8->setName('Stalefish');
        $trick8->setDescription('Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.');
        $trick8->setCategory($category1);
        $trick8->setDateCreation(new \DateTime('now'));
        $manager->persist($trick8);

        $trick9 = new Trick;
        $trick9->setName('180');
        $trick9->setDescription('Un 180 désigne un demi-tour, soit 180 degrés d\'angle.');
        $trick9->setCategory($category2);
        $trick9->setDateCreation(new \DateTime('now'));
        $manager->persist($trick9);

        $trick10 = new Trick;
        $trick10->setName('360');
        $trick10->setDescription('360, trois six pour un tour complet.');
        $trick10->setCategory($category2);
        $trick10->setDateCreation(new \DateTime('now'));
        $manager->persist($trick10);

        //Thumbnails
        $thumbnail1 = new Thumbnail;
        $thumbnail1->setExtension('jpeg');
        $thumbnail1->setAlt('indy-grab.jpg');
        $thumbnail1->setTrick($trick1);
        $manager->persist($thumbnail1);

        /*$thumbnail2 = new Thumbnail;
        $thumbnail2->setExtension('jpeg');
        $thumbnail2->setAlt('japan.jpg');
        $thumbnail2->setTrick($trick2);
        $manager->persist($thumbnail2);*/

        $thumbnail3 = new Thumbnail;
        $thumbnail3->setExtension('jpeg');
        $thumbnail3->setAlt('tail-grab.jpg');
        $thumbnail3->setTrick($trick3);
        $manager->persist($thumbnail3);

        /*$thumbnail4 = new Thumbnail;
        $thumbnail4->setExtension('jpeg');
        $thumbnail4->setAlt('nose-grab.jpg');
        $thumbnail4->setTrick($trick4);
        $manager->persist($thumbnail4);*/

        $thumbnail5 = new Thumbnail;
        $thumbnail5->setExtension('jpeg');
        $thumbnail5->setAlt('truck-driver.jpg');
        $thumbnail5->setTrick($trick5);
        $manager->persist($thumbnail5);

        $thumbnail6 = new Thumbnail;
        $thumbnail6->setExtension('jpeg');
        $thumbnail6->setAlt('mute-grab.jpg');
        $thumbnail6->setTrick($trick6);
        $manager->persist($thumbnail6);

        $thumbnail7 = new Thumbnail;
        $thumbnail7->setExtension('jpeg');
        $thumbnail7->setAlt('seat-belt.jpg');
        $thumbnail7->setTrick($trick7);
        $manager->persist($thumbnail7);

        $thumbnail8 = new Thumbnail;
        $thumbnail8->setExtension('jpeg');
        $thumbnail8->setAlt('stalefish.jpg');
        $thumbnail8->setTrick($trick8);
        $manager->persist($thumbnail8);

        $thumbnail9 = new Thumbnail;
        $thumbnail9->setExtension('jpeg');
        $thumbnail9->setAlt('180.jpg');
        $thumbnail9->setTrick($trick9);
        $manager->persist($thumbnail9);

        $thumbnail10 = new Thumbnail;
        $thumbnail10->setExtension('jpeg');
        $thumbnail10->setAlt('360.jpg');
        $thumbnail10->setTrick($trick10);
        $manager->persist($thumbnail10);

        //Images
        $image1 = new Image;
        $image1->setExtension('jpeg');
        $image1->setAlt('indy-grab-1.jpg');
        $image1->setTrick($trick1);
        $manager->persist($image1);

        $image2 = new Image;
        $image2->setExtension('jpeg');
        $image2->setAlt('indy-grab-2.jpg');
        $image2->setTrick($trick1);
        $manager->persist($image2);

        $image3 = new Image;
        $image3->setExtension('jpeg');
        $image3->setAlt('japan-1.jpg');
        $image3->setTrick($trick2);
        $manager->persist($image3);

        $image4 = new Image;
        $image4->setExtension('jpeg');
        $image4->setAlt('japan-2.jpg');
        $image4->setTrick($trick2);
        $manager->persist($image4);

        $image5 = new Image;
        $image5->setExtension('jpeg');
        $image5->setAlt('tail-grab-1.jpg');
        $image5->setTrick($trick3);
        $manager->persist($image5);

        $image6 = new Image;
        $image6->setExtension('jpeg');
        $image6->setAlt('tail-grab-2.jpg');
        $image6->setTrick($trick3);
        $manager->persist($image6);

        $image7 = new Image;
        $image7->setExtension('jpeg');
        $image7->setAlt('tail-grab-3.jpg');
        $image7->setTrick($trick3);
        $manager->persist($image7);

        /*$image8 = new Image;
        $image8->setExtension('jpeg');
        $image8->setAlt('nose-grab-1.jpg');
        $image8->setTrick($trick4);
        $manager->persist($image8);

        $image9 = new Image;
        $image9->setExtension('jpeg');
        $image9->setAlt('nose-grab-2.jpg');
        $image9->setTrick($trick4);
        $manager->persist($image9);*/

        $image10 = new Image;
        $image10->setExtension('jpeg');
        $image10->setAlt('truck-driver-1.jpg');
        $image10->setTrick($trick5);
        $manager->persist($image10);

        $image11 = new Image;
        $image11->setExtension('jpeg');
        $image11->setAlt('truck-driver-2.jpg');
        $image11->setTrick($trick5);
        $manager->persist($image11);

        $image12 = new Image;
        $image12->setExtension('jpeg');
        $image12->setAlt('mute-grab-1.jpg');
        $image12->setTrick($trick6);
        $manager->persist($image12);

        $image13 = new Image;
        $image13->setExtension('jpeg');
        $image13->setAlt('mute-grab-2.jpg');
        $image13->setTrick($trick6);
        $manager->persist($image13);

        $image14 = new Image;
        $image14->setExtension('jpeg');
        $image14->setAlt('seat-belt-1.jpg');
        $image14->setTrick($trick7);
        $manager->persist($image14);

        $image15 = new Image;
        $image15->setExtension('jpeg');
        $image15->setAlt('stalesfih-1.jpg');
        $image15->setTrick($trick8);
        $manager->persist($image15);

        $image16 = new Image;
        $image16->setExtension('jpeg');
        $image16->setAlt('stalesfih-2.jpg');
        $image16->setTrick($trick8);
        $manager->persist($image16);

        $image17 = new Image;
        $image17->setExtension('jpeg');
        $image17->setAlt('180-1.jpg');
        $image17->setTrick($trick9);
        $manager->persist($image17);

        $image18 = new Image;
        $image18->setExtension('jpeg');
        $image18->setAlt('360-1.jpg');
        $image18->setTrick($trick10);
        $manager->persist($image18);

        $image19 = new Image;
        $image19->setExtension('jpeg');
        $image19->setAlt('360-2.jpg');
        $image19->setTrick($trick10);
        $manager->persist($image19);


        //Videos
        $video1 = new Video;
        $video1->setUrl('https://www.youtube.com/embed/iKkhKekZNQ8');
        $video1->setTrick($trick1);
        $manager->persist($video1);

        $video2 = new Video;
        $video2->setUrl('https://www.youtube.com/embed/jH76540wSqU');
        $video2->setTrick($trick2);
        $manager->persist($video2);

        $video3 = new Video;
        $video3->setUrl('https://www.youtube.com/embed/id8VKl9RVQw');
        $video3->setTrick($trick3);
        $manager->persist($video3);

        $video4 = new Video;
        $video4->setUrl('https://www.youtube.com/embed/M-W7Pmo-YMY');
        $video4->setTrick($trick4);
        $manager->persist($video4);

        /*$video5 = new Video;
        $video5->setUrl('https://www.youtube.com/embed/6tgjY8baFT0');
        $video5->setTrick($trick5);
        $manager->persist($video5);*/

        $video6 = new Video;
        $video6->setUrl('https://www.youtube.com/embed/6z6KBAbM0MY');
        $video6->setTrick($trick6);
        $manager->persist($video6);

        $video7 = new Video;
        $video7->setUrl('https://www.youtube.com/embed/4vGEOYNGi_c');
        $video7->setTrick($trick7);
        $manager->persist($video7);

        $video8 = new Video;
        $video8->setUrl('https://www.youtube.com/embed/f9FjhCt_w2U');
        $video8->setTrick($trick8);
        $manager->persist($video8);

        $video9 = new Video;
        $video9->setUrl('https://www.youtube.com/embed/LMfEdzmxAns');
        $video9->setTrick($trick9);
        $manager->persist($video9);

        $video10 = new Video;
        $video10->setUrl('https://www.youtube.com/embed/ogZ8p08ecBU');
        $video10->setTrick($trick10);
        $manager->persist($video10);

        //Photos
        $photo1 = new Photo;
        $photo1->setExtension('png');
        $photo1->setAlt('user-1.png');
        $manager->persist($photo1);

        $photo2 = new Photo;
        $photo2->setExtension('png');
        $photo2->setAlt('user-2.png');
        $manager->persist($photo2);

        $photo3 = new Photo;
        $photo3->setExtension('png');
        $photo3->setAlt('user-3.png');
        $manager->persist($photo3);

        $photo4 = new Photo;
        $photo4->setExtension('png');
        $photo4->setAlt('user-4.png');
        $manager->persist($photo4);

        $photo5 = new Photo;
        $photo5->setExtension('png');
        $photo5->setAlt('user-5.png');
        $manager->persist($photo5);

        //Users
        $user1 = new User;
        $user1->setFirstName('Lisy');
        $user1->setLastName('Lake');
        $user1->setUsername('Lisy');
        $user1->setEmail('lisy.a@gmail.com');
        $user1->setIsActive('1');
        $user1->setPhoto($photo1);

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($user1, 'lisy');
        $user1->setPassword($password);

        $manager->persist($user1);

        $user2 = new User;
        $user2->setFirstName('Tyler');
        $user2->setLastName('Dillo');
        $user2->setUsername('Tyler');
        $user2->setEmail('tyler.d@gmail.com');
        $user2->setIsActive('1');
        $user2->setPhoto($photo2);

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($user2, 'tyler');
        $user2->setPassword($password);

        $manager->persist($user2);

        $user3 = new User;
        $user3->setFirstName('Tess');
        $user3->setLastName('Lake');
        $user3->setUsername('Nolan');
        $user3->setEmail('tess.n@gmail.com');
        $user3->setIsActive('1');
        $user3->setPhoto($photo3);

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($user3, 'tess');
        $user3->setPassword($password);

        $manager->persist($user3);

        $user4 = new User;
        $user4->setFirstName('Scott');
        $user4->setLastName('Couny');
        $user4->setUsername('Scott');
        $user4->setEmail('scott.c@gmail.com');
        $user4->setIsActive('1');
        $user4->setPhoto($photo4);

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($user4, 'scott');
        $user4->setPassword($password);

        $manager->persist($user4);

        $user5 = new User;
        $user5->setFirstName('Kate');
        $user5->setLastName('Lane');
        $user5->setUsername('Kate');
        $user5->setEmail('kate.l@gmail.com');
        $user5->setIsActive('1');
        $user5->setPhoto($photo5);

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($user5, 'kate');
        $user5->setPassword($password);

        $manager->persist($user5);

        //Comments
        $comment1 = new Comment;
        $comment1->setContent('Géniallissime !!!');
        $comment1->setDateCreation(new \DateTime('now'));
        $comment1->setUser($user1);
        $comment1->setTrick($trick1);
        $manager->persist($comment1);

        $comment2 = new Comment;
        $comment2->setContent('J\'adore aussi !!!');
        $comment2->setDateCreation(new \DateTime('now'));
        $comment2->setUser($user1);
        $comment2->setTrick($trick2);
        $manager->persist($comment2);

        $comment3 = new Comment;
        $comment3->setContent('Top !!!');
        $comment3->setDateCreation(new \DateTime('now'));
        $comment3->setUser($user2);
        $comment3->setTrick($trick1);
        $manager->persist($comment3);

        $comment4 = new Comment;
        $comment4->setContent('Topissime !!!');
        $comment4->setDateCreation(new \DateTime('now'));
        $comment4->setUser($user3);
        $comment4->setTrick($trick1);
        $manager->persist($comment4);

        $comment5 = new Comment;
        $comment5->setContent('Topissime !!!');
        $comment5->setDateCreation(new \DateTime('now'));
        $comment5->setUser($user3);
        $comment5->setTrick($trick2);
        $manager->persist($comment5);

        $comment6 = new Comment;
        $comment6->setContent('Topissime !!!');
        $comment6->setDateCreation(new \DateTime('now'));
        $comment6->setUser($user4);
        $comment6->setTrick($trick3);
        $manager->persist($comment6);
              
        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }
}