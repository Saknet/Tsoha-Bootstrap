<?php

class TopicController extends BaseController{
    
  public static function index(){
    $topics = Topic::all();
    View::make('topic/index.html', array('topics' => $topics));
  }
  
  public static function show($id) {
    $person = Topic::find($id);
    View::make('topic/show.html', array('topic' => $person));
  }  
}
