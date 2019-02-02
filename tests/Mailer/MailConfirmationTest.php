<?php

namespace App\Tests\Mailer;


use App\Entity\User;
use App\Mailer\Mailer;
use PHPUnit\Framework\TestCase;

class MailConfirmationTest extends TestCase
{
    public function testConfirmationMail()
    {

        $strFrom='test@gmail.com';
        $user=new User();
        $user->setEmail('maksim@gmail.com');

        $swiftMailer=$this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $swiftMailer->expects($this->once())->method('send')->with(
            $this->callback(function ($subject) use ($strFrom) {
                $messageStr=(string)$subject;
                //dump($messageStr);

                return strpos($messageStr,"From: ".$strFrom)
                    && strpos($messageStr,"This is a message body");
            })
        );

        $twig=$this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        //-- Check if twig can call 'render' method
        $twig->expects($this->once())->method('render')->with(
            'email/registration.html.twig', ['user' => $user]
        )->willReturn('This is a message body');


        $mailer=new Mailer($swiftMailer,$twig,$strFrom);
        $mailer->sendConfirmationEmail($user);
    }

}