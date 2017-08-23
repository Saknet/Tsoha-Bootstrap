<?php

  class BaseController{

    public static function get_user_logged_in() {
      if (isset($_SESSION['user'])) {
        $person_id = $_SESSION['user'];
        $person = Person::find($person_id);
        return $person;       
      }
    
    return null;
    }

    public static function check_logged_in() {
      if(!isset($_SESSION['user'])) {
        Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään'));
      }
    }
    
    public static function is_admin() {
      $person = Person::find($_SESSION['user']);
      return $person->admin;
    }
       
    public static function check_admin() {
      if(!self::is_admin()) {
        Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään ylläpitäjänä'));
      }        
    }
  }
