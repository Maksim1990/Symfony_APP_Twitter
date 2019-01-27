<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Entity\User;
use App\Form\MicroPostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * @Route("/micro-post")
 */
class MicroPostController extends AbstractController
{

    /**
     * @Route("/", name="micro_post_index")
     */
    public function index()
    {
        $posts = $this->getDoctrine()
            ->getRepository(MicroPost::class)
            ->findAllDescending();

        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts,
        ]);
    }


    /**
     * @Route("/add", name="micro_post_add")
     * @param Request $request
     * @param TokenStorageInterface $storage
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('ROLE_USER')")
     */
    //public function add(Request $request)

    //SECOND OPTION TO RETRIEVE CURRENTLY AUTHENTICATED USER
    public function add(Request $request, TokenStorageInterface $storage)
    {
        $microPost=new MicroPost();

        //NOW WE ADD IT IN PRE PERSIST LIFEHOOK
        //$microPost->setTime(new \DateTime());

        //$user= $this->getUser();
        $user= $storage->getToken()->getUser();

        $form=$this->createForm(MicroPostType::class,$microPost);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $microPost->setUser($user);
            $em->persist($microPost);
            $em->flush();

            return   $this->redirectToRoute('micro_post_index');
        }

        return $this->render('micro_post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="micro_post_edit")
     * @Security("is_granted('edit', microPost)", message="Access denied")
     */
    public function edit(MicroPost $microPost,Request $request)
    {

        $form=$this->createForm(MicroPostType::class,$microPost);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            return   $this->redirectToRoute('micro_post_index');
        }

        return $this->render('micro_post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/delete/{id}", name="micro_post_delete")
     */
    public function delete(MicroPost $microPost)
    {
        $this->denyAccessUnlessGranted('delete',$microPost);
        $em=$this->getDoctrine()->getManager();
        $em->remove($microPost);
        $em->flush();
        $this->addFlash('notice', 'Micro post was deleted');

        return   $this->redirectToRoute('micro_post_index');
    }
    /**
     * @Route("/{id}", name="micro_post_show")
     */
    public function show(MicroPost $microPost)
    {
//        $microPost = $this->getDoctrine()
//            ->getRepository(MicroPost::class)
//            ->find($id);
        return $this->render('micro_post/show.html.twig', [
            'post' => $microPost,
        ]);
    }

    /**
     * @Route("/user/{username}", name="micro_post_user")
     * @param User $userWIthPosts
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userPosts(User $userWIthPosts){

        $posts = $this->getDoctrine()
            ->getRepository(MicroPost::class)
            ->findBy([
               'user'=>$userWIthPosts
            ],
                ['time'=>'DESC']);

        return $this->render('micro_post/user_posts.html.twig', [
            'posts' => $posts,
            'user'=>$userWIthPosts
        ]);
    }
}
