<?php

namespace Tests\ST\UserBundle\Entity;

use PHPUnit\Framework\TestCase;
use ST\UserBundle\Entity\User;
use ST\UserBundle\Entity\Photo;

class UserTest extends TestCase
{
    public function testSetFirstNameUser()
    {
    	$user = new User;
    	$user->setFirstName('Lisy');
    	$this->assertSame('Lisy', $user->getFirstName());
    }

    public function testSetLastNameUser()
    {
        $user = new User;
        $user->setLastName('Lake');
        $this->assertSame('Lake', $user->getLastName());
    }

    public function testSetUsernameUser()
    {
        $user = new User;
        $user->setUsername('Lisy');
        $this->assertSame('Lisy', $user->getUsername());
    }

    public function testSetEmailUser()
    {
        $user = new User;
        $user->setEmail('lisy.a@gmail.com');
        $this->assertSame('lisy.a@gmail.com', $user->getEmail());
    }

    public function testSetPlainPasswordUser()
    {
        $user = new User;
        $user->setPlainPassword('lisy');
        $this->assertSame('lisy', $user->getPlainPassword());
    }

    public function testSetPasswordUser()
    {
        $user = new User;
        $user->setPassword('lisy');
        $this->assertSame('lisy', $user->getPassword());
    }

    public function testSetConfirmationTokenUser()
    {
        $user = new User;
        $user->setConfirmationToken('$2y$13$bclp1q8Pzj54xVBvmPhz7ecimj70GlrxklbAVA550Va1cjyTdwd.q');
        $this->assertSame('$2y$13$bclp1q8Pzj54xVBvmPhz7ecimj70GlrxklbAVA550Va1cjyTdwd.q', $user->getConfirmationToken());
    }

    public function testSetIsActiveUser()
    {
        $user = new User;
        $user->setIsActive('1');
        $this->assertSame('1', $user->getIsActive());
    }

    public function testGetPhotoAltUser()
    {
        $user = new User;
        $photo = new Photo;

        $user->setPhoto($photo);
        $photo->setAlt('Lisy');
        
        $this->assertEquals('Lisy', $user->getPhoto()->getAlt());
    }
}
