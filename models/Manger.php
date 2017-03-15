<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of Manger
 *
 * @author Administrator
 */
class Manger {
    public static $obj=null;
    
     
 
    public static function getInstance(){
           if(Manger::$obj==null){
            Manger::$obj=new Manger();
        }
        return Manger::$obj;
    }

    //put your code here
}
