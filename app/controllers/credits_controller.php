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
    $persons = Person::all();
    $topics = Topic::all();
    View::make('credit/new.html', array('persons' => $persons, 'topics' => $topics));   
  }
  
  public static function store(){
    $params = $_POST;
      
    if(!isset($params['interrupted'])) {
      $params['interrupted'] = null;
    } 
      
    $attributes = array(
      'givenby' => $params['givenby'],
      'topic' => $params['topic'],
      'interrupted' => $params['interrupted'],
      'startdate' => $params['startdate'],
      'enddate' => $params['enddate'],
      'grade' => $params['grade']                  
    );

    $credit = new Credit($attributes);    
    $errors = $credit->errors();

    if(count($errors) == 0) {
      $credit->save();
      Redirect::to('/credit/' . $credit->id, array('message' => 'Suorituksen tiedot lisättiin järjestelmään!'));
    } else {
        View::make('credit/new.html', array('errors' => $errors, 'attributes' => $attributes));
    }
  }
}