<?php

class CourseController extends BaseController{
    
  public static function index(){
    $courses = Course::all();
    View::make('course/index.html', array('courses' => $courses));
  }
  
  public static function show($id) {
    $course = Course::find($id);
    View::make('course/show.html', array('course' => $course));
  }  
}
