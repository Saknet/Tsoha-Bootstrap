<?php
/**
 *  Handles requests related to course model.
 */
class CourseController extends BaseController{
   
  /**
   * Lists all courses.
   */    
  public static function index() {
    $courses = Course::all();
    View::make('course/index.html', array('courses' => $courses));
  }
 
  /**
   * Shows a course's view.
   *
   * @param int $id Id of the course.
   */  
  public static function show($id) {
    $course = Course::find($id);
    $topics = Topic::find_by_course($id);
    View::make('course/show.html', array('course' => $course, 'topics' => $topics));
  }  
  
  /**
   * Shows page for new course creation.
   */  
  public static function create() {
    self::check_admin();
    $persons = Person::all();
    View::make('course/new.html', array('persons' => $persons));   
  }
  
  /**
   * Attempts to save new course into database, then redirects to the newly created course's view.
   */  
  public static function store() {
    $params = $_POST;
    
    if (!isset($params['incharge'])) {
      $params['incharge'] = null;
    }
    
    $attributes = array(
      'name' => $params['name'],
      'incharge' => $params['incharge']
    );
    
    $course = new Course($attributes);  
    $errors = $course->errors();

    if (count($errors) == 0) {
      $course->save();
      Redirect::to('/course/' . $course->id, array('message' => 'Kurssin tiedot lisättiin järjestelmään!'));
    } else {
      $persons = Person::all();  
      View::make('course/new.html', array('errors' => $errors, 'attributes' => $attributes, 'persons' => $persons));
    }
  }
  
  /**
   * Shows a course edit page.
   *
   * @param int $id Id of a course.
   */  
  public static function edit($id) {
    self::check_logged_in();
    $course = Course::find($id);
    $persons = Person::all();
    View::make('course/edit.html', array('attributes' => $course, 'persons' => $persons));
  }
  
  /**
   * Attempts to update a course information, then redirects to edited course's view.
   *
   * @param int $id Id of a course.
   */  
  public static function update($id) {
    $params = $_POST;
    
    if (!isset($params['incharge'])) {
      $params['incharge'] = null;
    }
    
    $attributes = array(
      'id' => $id,
      'name' => $params['name'],
      'incharge' => $params['incharge']
    ); 

    $course = new Course($attributes);
    $errors = $course->errors();

    if (count($errors) > 0){
      $persons = Person::all(); 
      View::make('course/edit.html', array('errors' => $errors, 'attributes' => $attributes, 'persons' => $persons, 'editcheck' => true));
    } else {
      $course->update();
      Redirect::to('/course/' . $course->id, array('message' => 'Kurssin tietoja muokattiin onnistuneesti!'));
    }
  }

  /**
   * Attempts to destroy a course, then redirects to course listing.
   *
   * @param int $id Id of a course.
   */  
  public static function destroy($id) {
    self::check_admin();
    $course = new Course(array('id' => $id));
    $course->destroy();

    Redirect::to('/course', array('message' => 'Kurssi poistettiin onnistuneesti!'));
  }  
}
