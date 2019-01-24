<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


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
            ->findAllGreaterThanIdSQL(7);

        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts,
        ]);
    }


    /**
     * @Route("/add", name="micro_post_add")
     */
    public function add(Request $request)
    {

        $microPost=new MicroPost();
        $microPost->setTime(new \DateTime());

        $form=$this->createForm(MicroPostType::class,$microPost);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
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
}
