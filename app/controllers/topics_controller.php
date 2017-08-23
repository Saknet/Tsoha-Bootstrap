<?php

class TopicController extends BaseController{
     
  public static function index() {
      
    if (isset($_GET['page'])){
      $page = preg_replace("#[^0-9]#","",$_GET['page']);                
    } else {
      $page = 1;                      
    }  
       
    $totalTopics = Topic::count();
    $pages = ceil($totalTopics/5);  
    $topics = Topic::all($page);
    
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
    
    View::make('topic/index.html', array('topics' => $topics, 'pages' => $pages, 'prev_page' => $prev_page, 'next_page' => $next_page));
  }
  
  public static function show($id) {
    $topic = Topic::find($id);
    $credits = Credit::find_by_topic($id);
    $persons = Person::find_many_persons_with_topic_id($id);
    View::make('topic/show.html', array('topic' => $topic, 'credits' => $credits, 'persons' => $persons));
  }
  
  public static function create() {
    self::check_logged_in();
    $persons = Person::all();
    $courses = Course::all();
    View::make('topic/new.html', array('persons' => $persons, 'courses' => $courses));   
  }
  
  public static function store() {
    $params = $_POST;
    
    if (!isset($params['persons'])) {
      $params['persons'] = null;
    }
    
    if (!isset($params['course'])) {
      $params['course'] = null;
    }
    
    $attributes = array(
      'name' => $params['name'],
      'persons' => $params['persons'],
      'description' => $params['description'],
      'course' => $params['course']       
    );
    
    $topic = new Topic($attributes);  
    $errors = $topic->errors();
    
    if (count($errors) == 0) {
      $topic->save();
      Redirect::to('/topic/' . $topic->id, array('message' => 'Aiheen tiedot lisättiin järjestelmään!'));
    } else {
      $persons = Person::all();
      $courses = Course::all();  
      View::make('topic/new.html', array('errors' => $errors, 'attributes' => $attributes, 'persons' => $persons, 'courses' => $courses));   
    }
  }
  
  public static function edit($id) {
    self::check_logged_in();
    $persons = Person::all();
    $courses = Course::all();
    $topic = Topic::find($id);
    View::make('topic/edit.html', array('attributes' => $topic, 'persons' => $persons, 'courses' => $courses));
  }
  
  public static function update($id) {
    $params = $_POST;
    
    if (!isset($params['persons'])) {
      $params['persons'] = null;
    }
    
    if (!isset($params['course'])) {
      $params['course'] = null;
    }
    
    $attributes = array(
      'id' =>  $id,
      'name' => $params['name'],
      'topic' => $id,
      'persons' => $params['persons'],
      'description' => $params['description'],
      'course' => $params['course']       
    );

    $topic = new Topic($attributes);
    $errors = $topic->errors();

    if (count($errors) > 0){
      $persons = Person::all();
      $courses = Course::all();         
      View::make('topic/edit.html', array('errors' => $errors, 'attributes' => $attributes, 'persons' => $persons, 'courses' => $courses, 'editcheck' => true));     
    } else {
      $topic->update();
      Redirect::to('/topic/' . $topic->id, array('message' => 'Aiheen tietoja muokattiin onnistuneesti!'));
    }
  }

  public static function destroy($id) {
    self::check_logged_in();
    $topic = new Topic(array('id' => $id));
    $topic->destroy();

    Redirect::to('/topic', array('message' => 'Aihe poistettiin onnistuneesti!'));
  }  
}