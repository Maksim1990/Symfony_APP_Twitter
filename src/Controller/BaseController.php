<?php
namespace App\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/blog")
 */
class BaseController extends AbstractController{

    private $session;

    public function __construct(SessionInterface $session)
    {

        $this->session=$session;
    }

    /**
     * @Route("/",name="blog_index")
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(){
        $posts=$this->session->get("posts");

        return $this->render("blog/index.html.twig",['posts'=>$posts]);
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

        return $this->redirectToRoute('blog_index');
    }

    /**
     * @Route("/show/{id}",name="blog_show")
     */
    public function show($id){
        $posts=$this->session->get("posts");
        if(!empty($posts) && isset($posts[$id])){
            return $this->render("blog/show.html.twig",[
                'id'=>$id,
                'post'=>$posts[$id],
            ]);
        }
        throw new NotFoundHttpException("Post not found!");
    }

}