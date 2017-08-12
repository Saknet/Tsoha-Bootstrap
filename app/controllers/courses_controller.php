<?php

class CourseController extends BaseController{
    
  public static function index(){
    $courses = Course::all();
    View::make('course/index.html', array('courses' => $courses));
  }
  
  public static function show($id) {
    $course = Course::find($id);
    $topics = Topic::find_by_course($id);
    View::make('course/show.html', array('course' => $course, 'topics' => $topics));
  }  
  
  public static function create() {
    $persons = Person::all();
    View::make('course/new.html', array('persons' => $persons));   
  }
  
  public static function store(){
    $params = $_POST;
    $attributes = array(
      'name' => $params['name'],
      'incharge' => $params['incharge']
    );
    
    $course = new Course($attributes);  
    $errors = $course->errors();

    if(count($errors) == 0) {
      $course->save();
      Redirect::to('/course/' . $course->id, array('message' => 'Kurssin tiedot lisättiin järjestelmään!'));
    } else {
      View::make('course/new.html', array('errors' => $errors, 'attributes' => $attributes));
    }
  }
}
