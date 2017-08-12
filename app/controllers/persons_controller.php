<?php

class PersonController extends BaseController{
    
  public static function index(){
    $persons = Person::all();
    View::make('person/index.html', array('persons' => $persons));
  }
  
  public static function show($id) {
    $person = Person::find($id);
    $topics = Topic::find_by_person($id);
    $courses = Course::find_by_person($id);
    View::make('person/show.html', array('person' => $person, 'topics' => $topics, 'courses' => $courses));
  }
  
  public static function create() {
    View::make('person/new.html');   
  }
  
  public static function store(){
    $params = $_POST;
    $attributes = array(
      'name' => $params['name'],
      'username' => $params['username'],
      'password' => $params['password']
    );
    
    $person = new Person($attributes);
    $errors = $person->errors();
    
    if(count($errors) == 0) {
      $person->save();
      Redirect::to('/person/' . $person->id, array('message' => 'Henkilön tiedot lisättiin tietokantaan!'));
    } else {
        View::make('person/new.html', array('errors' => $errors, 'attributes' => $attributes));        
    }
  }
}

