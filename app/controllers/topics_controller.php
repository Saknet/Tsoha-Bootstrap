<?php

class TopicController extends BaseController{
    
  public static function index(){
    $topics = Topic::all();
    View::make('topic/index.html', array('topics' => $topics));
  }
  
  public static function show($id) {
    $topic = Topic::find($id);
    $credits = Credit::find_by_topic($id);
    View::make('topic/show.html', array('topic' => $topic, 'credits' => $credits));
  }
  
  public static function create() {
    $persons = Person::all();
    $courses = Course::all();
    View::make('topic/new.html', array('persons' => $persons, 'courses' => $courses));   
  }
  
  public static function store(){
    $params = $_POST;
    $topic = new Topic(array(
      'name' => $params['name'],
      'addedby' => $params['addedby'],
      'description' => $params['description'],
      'course' => $params['course']       
    ));
       
    $topic->save();
    Redirect::to('/topic/' . $topic->id, array('message' => 'Aiheen tiedot lisättiin järjestelmään!'));
  }
}