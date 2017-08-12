<?php

class TopicController extends BaseController{
    
  public static function index(){
    $topics = Topic::all();
    View::make('topic/index.html', array('topics' => $topics));
  }
  
  public static function show($id) {
    $topic = Topic::find($id);
    $credits = Credit::find_by_topic($id);
    $persons = Person::find_many_persons_with_topic_id($id);
    View::make('topic/show.html', array('topic' => $topic, 'credits' => $credits, 'persons' => $persons));
  }
  
  public static function create() {
    $persons = Person::all();
    $courses = Course::all();
    View::make('topic/new.html', array('persons' => $persons, 'courses' => $courses));   
  }
  
  public static function store(){
    $params = $_POST;
    $attributes = array(
      'name' => $params['name'],
      'person' => $params['person'],
      'description' => $params['description'],
      'course' => $params['course']       
    );
    
    $topic = new Topic($attributes);  
    $errors = $topic->errors();
    
    if(count($errors) == 0) {
      $topic->save();
      Redirect::to('/topic/' . $topic->id, array('message' => 'Aiheen tiedot lisättiin järjestelmään!'));
    } else {
      View::make('topic/new.html', array('errors' => $errors, 'attributes' => $attributes));   
    }
  }
}