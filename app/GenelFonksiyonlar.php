<?php

namespace App;

class GenelFonksiyonlar
{
    public static  function getIp(){
         /*$ip = $_SERVER['REMOTE_ADDR'];
         $ulkeKod = \Location::get($ip)->countryCode;*/
         $ip = 1111;
         $ulkeKod = "TR";
         $ipUlke = ['ip' => $ip, 'ulkeKod' => $ulkeKod];

         return $ipUlke;
     }
}