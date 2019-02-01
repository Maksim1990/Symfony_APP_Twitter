<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\UserRegisterEvent;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController{

    /**
     * @Route("/register", name="user_register")
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $encoder
     * @param \Symfony\Component\HttpFoundation\Request                             $request
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface           $dispatcher
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(UserPasswordEncoderInterface $encoder,Request $request, EventDispatcherInterface $dispatcher){

        $user=new User();
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password=$encoder->encodePassword(
                $user,
                $user->getPlainPassword()
            );
            $user->setPassword($password);

            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $userRegisterEvent= new UserRegisterEvent($user);

            $dispatcher->dispatch(UserRegisterEvent::NAME, $userRegisterEvent);

           return $this->redirectToRoute('micro_post_index');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}