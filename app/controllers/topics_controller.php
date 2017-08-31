<?php
/**
 *  Handles requests related to topic model.
 */
class TopicController extends BaseController{
    
  /**
   * Lists all topics, using paging. 
   */      
  public static function index() {      
    if (isset($_GET['page'])){
      $page = preg_replace("#[^0-9]#","",$_GET['page']);                
    } else {
      $page = 1;                      
    }  
       
    $totalTopics = Topic::count();
    $page_size = 10;
    $pages = ceil($totalTopics/$page_size);  
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
  
  /**
   * Shows a topic's view.
   *
   * @param int $id Id of the topic.
   */  
  public static function show($id) {
    $topic = Topic::find($id);
    $credits = Credit::find_by_topic($id);
    $persons = Person::find_many_persons_with_topic_id($id);
    View::make('topic/show.html', array('topic' => $topic, 'credits' => $credits, 'persons' => $persons));
  }
  
  /**
   * Shows page for new topic creation.
   */   
  public static function create() {
    self::check_logged_in();
    $persons = Person::all(-1);
    $courses = Course::all(-1);
    View::make('topic/new.html', array('persons' => $persons, 'courses' => $courses));   
  }
  
  /**
   * Attempts to save new topic into database, then redirects to the newly created topic's view.
   */   
  public static function store() {
    self::check_logged_in();  
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
      $persons = Person::all(-1);
      $courses = Course::all(-1);  
      View::make('topic/new.html', array('errors' => $errors, 'attributes' => $attributes, 'persons' => $persons, 'courses' => $courses));   
    }
  }
  
  /**
   * Shows a topic edit page.
   *
   * @param int $id Id of a topic.
   */   
  public static function edit($id) {
    self::check_logged_in();
    $persons = Person::all(-1);
    $courses = Course::all(-1);
    $topic = Topic::find($id);
    View::make('topic/edit.html', array('attributes' => $topic, 'persons' => $persons, 'courses' => $courses));
  }
  
  /**
   * Attempts to update a topic information, then redirects to edited topic's view.
   *
   * @param int $id Id of a topic.
   */   
  public static function update($id) {
    self::check_logged_in();   
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
      $persons = Person::all(-1);
      $courses = Course::all(-1);         
      View::make('topic/edit.html', array('errors' => $errors, 'attributes' => $attributes, 'persons' => $persons, 'courses' => $courses, 'editcheck' => true));     
    } else {
      $topic->update();
      Redirect::to('/topic/' . $topic->id, array('message' => 'Aiheen tietoja muokattiin onnistuneesti!'));
    }
  }

  /**
   * Attempts to destroy a topic, then redirects to topic listing.
   *
   * @param int $id Id of a topic.
   */  
  public static function destroy($id) {
    self::check_logged_in();
    $topic = new Topic(array('id' => $id));
    $topic->destroy();

    Redirect::to('/topic', array('message' => 'Aihe poistettiin onnistuneesti!'));
  }  
}