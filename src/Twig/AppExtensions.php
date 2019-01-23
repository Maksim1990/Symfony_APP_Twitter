<?php
/**
 * Created by PhpStorm.
 * User: Maxim.Narushevich
 * Date: 23.01.2019
 * Time: 16:27
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtensions extends AbstractExtension implements GlobalsInterface
{

    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getFilters()
    {
        return [
          new TwigFilter('price',[$this,'priceFilter']),
          new TwigFilter('add_salt',[$this,'addSalt']),
        ];
    }

    public function priceFilter($number){
        return '$'. number_format($number,2,'.',',');
    }

    public function addSalt($text){
        return $text." some salt";
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        return [
            'test_twig_message'=>$this->message
        ];
    }
}