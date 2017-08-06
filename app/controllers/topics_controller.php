<?php

class TopicController extends BaseController{
    
  public static function index(){
    $topics = Topic::all();
    View::make('topic/index.html', array('topics' => $topics));
  }
}
