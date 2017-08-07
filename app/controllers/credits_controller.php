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
  public static function create() {
    View::make('credit/new.html');   
  }
  
  public static function store(){
    $params = $_POST;
    $credit = new Credit(array(
      'givenby' => $params['givenby'],
      'topic' => $params['topic'],
      'interrupted' => $params['interrupted'],
      'startdate' => $params['startdate'],
      'enddate' => $params['enddate'],
      'grade' => $params['grade']                  
    ));

    $credit->save();
    Redirect::to('/credit/' . $credit->id, array('message' => 'Suorituksen tiedot lisättiin järjestelmään!'));
  }
}