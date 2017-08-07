<?php

class CreditController extends BaseController{
    
  public static function index(){
    $credits = Credit::all();
    View::make('credit/index.html', array('credits' => $credits));
  }
  
  public static function show($id) {
    $credit = Credit::find($id);
    View::make('credit/show.html', array('credit' => $credit));
  }
}
