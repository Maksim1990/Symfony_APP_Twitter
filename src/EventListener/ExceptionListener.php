<?php

namespace App\EventListener;

use App\Exceptions\UserNotEnabledException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();
        $message = sprintf(
            'My Error says: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        // Customize your response object to display the exception details
        $response = new Response();
        $response->setContent($message);

        //  CHECK FOR SPECIFIC USER EXCEPTION
        if ($exception instanceof UserNotEnabledException) {

            $html=$this->twig->render(
                'exceptions/user_not_enabled.html.twig',[]);
            $response = new Response($html);
            $event->setResponse($response);
        } else {
           // $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // sends the modified response object to the event
        //$event->setResponse($response);
    }
}