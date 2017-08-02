<?php

  class HelloWorldController extends BaseController{

    public static function index(){
        View::make('suunnitelmat/login.html');
    }

    public static function sandbox(){
        View::make('helloworld.html');
    }
    
    public static function credit_list(){
        View::make('suunnitelmat/credit_list.html');
    }

    public static function credit_show(){
        View::make('suunnitelmat/credit_show.html');
    }
    
    public static function credit_edit(){
        View::make('suunnitelmat/credit_edit.html');
    }
    
    public static function person_list(){
        View::make('suunnitelmat/person_list.html');
    }

    public static function person_show(){
        View::make('suunnitelmat/person_show.html');
    }
    
    public static function person_edit(){
        View::make('suunnitelmat/person_edit.html');
    }
    
    public static function topic_list(){
        View::make('suunnitelmat/topic_list.html');
    }

    public static function topic_show(){
        View::make('suunnitelmat/topic_show.html');
    }
    
    public static function topic_edit(){
        View::make('suunnitelmat/topic_edit.html');
    }
    
    public static function login(){
        View::make('suunnitelmat/login.html');
    }
 
    }
