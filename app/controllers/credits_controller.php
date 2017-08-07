<?php

class CreditController extends BaseController{
    
  public static function index(){
    $credits = Credit::all();
    View::make('credit/index.html', array('credits' => $credits));
  }
}
