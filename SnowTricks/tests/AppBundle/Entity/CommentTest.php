<?php

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Trick;
use AppBundle\Entity\User;

class CommentTest extends TestCase
{
    /**
     *
     */
    public function testSetDateCreationComment()
    {
        $comment = new Comment;
        $comment->setDateCreation('2018-02-14 17:32:00');
        $this->assertSame('2018-02-14 17:32:00', $comment->getDateCreation());
    }

    /**
     *
     */
    public function testSetContentComment()
    {
        $comment = new Comment;
        $comment->setContent('Génial !!');
        $this->assertSame('Génial !!', $comment->getContent());
    }

    /**
     *
     */
    public function testGetTrickNameComment()
    {
        $comment = new Comment;
        $trick = new Trick;

        $comment->setTrick($trick);
        $trick->setName('Japan');
        
        $this->assertEquals('Japan', $comment->getTrick()->getName());
    }

    /**
     *
     */
    public function testGetUserUsernameComment()
    {
        $comment = new Comment;
        $user = new User;

        $comment->setUser($user);
        $user->setUsername('Lisy');
        
        $this->assertEquals('Lisy', $comment->getUser()->getUsername());
    }
}
