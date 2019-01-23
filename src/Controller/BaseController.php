<?php
namespace App\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BaseController {

    private $twig;
    private $session;
    public function __construct(\Twig_Environment $twig,SessionInterface $session)
    {
        $this->twig=$twig;
        $this->session=$session;
    }

    /**
     * @Route("/",name="blog_index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(){
        $posts=$this->session->get("posts");
        dd($posts);
        $html=$this->twig->render("base.html.twig",['message'=>"Test"]);
       return new Response($html);
    }

    /**
     * @Route("/add/",name="blog_add")
     */
    public function add(){
        $posts=$this->session->get("posts");
        $posts[uniqid()]=[
            'title'=>'This is title '.rand(0,500),
            'text'=>'This is text '.rand(0,500),
        ];
        $this->session->set("posts",$posts);

        return new Response("Created");
    }

    /**
     * @Route("/show/{id}",name="blog_show")
     */
    public function show($id){
        $posts=$this->session->get("posts");
        if(!empty($posts) && isset($posts[$id])){
            dd($posts[$id]);
        }
        throw new NotFoundHttpException("Post not found!");
    }

}