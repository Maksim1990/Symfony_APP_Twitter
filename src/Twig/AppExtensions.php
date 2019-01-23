<?php
/**
 * Created by PhpStorm.
 * User: Maxim.Narushevich
 * Date: 23.01.2019
 * Time: 16:27
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtensions extends AbstractExtension
{
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
}