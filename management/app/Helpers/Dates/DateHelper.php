<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers\Dates;

class DateHelper {
    
     public static function getString($date) {
         if($date == date('Y-m-d', strtotime(Carbon::now()))){
             return "Hoje";
         }elseif($date == date('Y-m-d', strtotime(Carbon::now()->SubDays(1)))){
             return "Ontem";
         }
     }

}
