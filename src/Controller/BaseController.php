<?php
namespace App\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController {

    private $greeting;
    public function __construct(\App\Services\Greeting $greeting)
    {
        $this->greeting=$greeting;
    }


    /**
     * @Route("/",name="greet_route")
     */
    public function greet(Request $request){
       return $this->render("base.html.twig",['message'=>$this->greeting->greet(
           $request->get('name')
       )]);
    }

}