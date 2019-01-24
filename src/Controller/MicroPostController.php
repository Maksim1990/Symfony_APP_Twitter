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
            ->findAllDescending();

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
}
