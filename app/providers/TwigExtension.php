<?php

namespace App\Providers;

use Database\Buyer;
use Database\Category;
use Database\Product;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('asset', [$this, 'asset']),
            new TwigFunction('show_message', [$this, 'show_message']),
            new TwigFunction('env', [$this, 'env']),
        ];
    }


    public function asset($filename){
        return trim($_ENV['APP_URL'],'/').'/'.trim($filename,'/');
    }

    public function env($var){
        return isset($_ENV[$var])?$_ENV[$var]:'--';
    }

    public function show_message(){
        if(isset($_SESSION['message'])){
            if(is_array($_SESSION['message']['text'])){
                $str = '<div class="alert '.$_SESSION['message']['type'].'" role="alert"><ul>';
                foreach($_SESSION['message']['text'] as $text){
                    $str .= '<li>'.$text.'</li>';
                }
                $str .=  '</ul></div>';
            }else{

                $str = '<div class="alert '.$_SESSION['message']['type'].'" role="alert">
                                '.$_SESSION['message']['text'].'
                        </div>';
            }
            unset($_SESSION['message']);
        }else{
            $str = '';
        }

        return $str;
    }
}