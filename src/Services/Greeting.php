<?php
/**
 * Created by PhpStorm.
 * User: Maxim.Narushevich
 * Date: 21.01.2019
 * Time: 16:53
 */

namespace App\Services;


use Psr\Log\LoggerInterface;

class Greeting
{

    private $logger;
    private $message;
    public function __construct(LoggerInterface $logger,string $message)
    {
        $this->logger=$logger;
        $this->message=$message;
    }

    public function greet(string $message):string {
        $this->logger->info("Greeted ".$message);
        return "{$this->message} $message";
    }

}