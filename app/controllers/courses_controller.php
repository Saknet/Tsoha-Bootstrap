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
    View::make('course/new.html');   
  }
  
  public static function store(){
    $params = $_POST;
    $course = new Course(array(
      'name' => $params['name'],
      'incharge' => $params['incharge']
    ));

    $course->save();
    Redirect::to('/course/' . $course->id, array('message' => 'Kurssin tiedot lisättiin järjestelmään!'));
  }
}
