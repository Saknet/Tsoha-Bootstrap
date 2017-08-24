<?php

class CreditController extends BaseController{
    
  public static function index() {
    if (isset($_GET['page'])){
      $page = preg_replace("#[^0-9]#","",$_GET['page']);                
    } else {
      $page = 1;                      
    }  
       
    $totalCredits = Credit::count();
    $pages = ceil($totalCredits/5);  
    $credits = Credit::all($page);
    
    if ($page > 1) {
      $prev_page = $page - 1;
    } else {
      $prev_page = 1;
    }
    
    if ($page < $pages) {
      $next_page = $page + 1;
    } else {
      $next_page = $pages; 
    }
    
    View::make('credit/index.html', array('credits' => $credits, 'pages' => $pages, 'prev_page' => $prev_page, 'next_page' => $next_page));
  }
  
  public static function show($id) {
    $credit = Credit::find($id);
    View::make('credit/show.html', array('credit' => $credit));
  }
  public static function create() {
    self::check_logged_in();
    $persons = Person::all();
    $topics = Topic::all(-1);
    View::make('credit/new.html', array('persons' => $persons, 'topics' => $topics));   
  }
  
  public static function store() {
    $params = $_POST;
      
    if (!isset($params['interrupted'])) {
      $params['interrupted'] = null;
    } else {
      $params['grade'] = 0;  
    }
    
    if (!isset($params['givenby'])) {
      $params['givenby'] = null;
    }
    
    if (!isset($params['topic'])) {
      $params['topic'] = null;
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

    if (count($errors) == 0) {
      $credit->save();
      Redirect::to('/credit/' . $credit->id, array('message' => 'Suorituksen tiedot lisättiin järjestelmään!'));
    } else {
      $persons = Person::all();
      $topics = Topic::all();
      View::make('credit/new.html', array('errors' => $errors, 'attributes' => $attributes, 'persons' => $persons, 'topics' => $topics));
    }
  }
  
  public static function edit($id) {
    self::check_logged_in();      
    $persons = Person::all();
    $topics = Topic::all(-1);
    $credit = Credit::find($id);
    View::make('credit/edit.html', array('attributes' => $credit, 'persons' => $persons, 'topics' => $topics));
  }
  
  public static function update($id) {
    $params = $_POST;
    
    if (!isset($params['interrupted'])) {
      $params['interrupted'] = null;
    } else {
      $params['grade'] = 0;  
    }
    
    if (!isset($params['givenby'])) {
      $params['givenby'] = null;
    }
    
    if (!isset($params['topic'])) {
      $params['topic'] = null;
    }
    
    $attributes = array(
      'id' =>  $id,
      'givenby' => $params['givenby'],
      'topic' => $params['topic'],
      'interrupted' => $params['interrupted'],
      'startdate' => $params['startdate'],
      'enddate' => $params['enddate'],
      'grade' => $params['grade']     
    );

    $credit = new Credit($attributes);
    $errors = $credit->errors();

    if (count($errors) > 0){
      $persons = Person::all();
      $topics = Topic::all();  
      View::make('credit/edit.html', array('errors' => $errors, 'attributes' => $attributes, 'persons' => $persons, 'topics' => $topics, 'editcheck' => true));
    } else {
      $credit->update();
      Redirect::to('/credit/' . $credit->id, array('message' => 'Suorituksen tietoja muokattiin onnistuneesti!'));
    }
  }

  public static function destroy($id) {
    self::check_logged_in();  
    $credit = new Credit(array('id' => $id));
    $credit->destroy();

    Redirect::to('/credit', array('message' => 'Suoritus poistettiin onnistuneesti!'));
  }
}