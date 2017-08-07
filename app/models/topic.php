<?php

class Topic extends BaseModel{

  public $id, $name, $addedby, $description, $course;

  public function __construct($attributes){
    parent::__construct($attributes);
  }
  
  public static function all(){

    $query = DB::connection()->prepare('SELECT * FROM Topic');
    $query->execute();
    $rows = $query->fetchAll();
    $topics = array();

    foreach($rows as $row){
      $topics[] = new Topic(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'addedby' => Person::find($row['addedby']),
        'description' => $row['description'],
        'course' => Course::find($row['course'])
      ));
    }

    return $topics;
  }
  
  public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM Topic WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
      $topic = new Topic(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'addedby' => Person::find($row['addedby']),
        'description' => $row['description'],
        'course' => Course::find($row['course'])
      ));

      return $topic;
    }

    return null;
  }
  
  public static function find_by_course($id) {
    $query = DB::connection()->prepare('SELECT * FROM Topic WHERE course = :id');
    $query->execute(array('id' => $id));
    $rows = $query->fetchAll();
    $topics = array();

    foreach($rows as $row){
      $topics[] = new Topic(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'addedby' => Person::find($row['addedby']),
        'description' => $row['description'],
      ));
    }

    return $topics;
  }
  
  public static function find_by_person($id) {
    $query = DB::connection()->prepare('SELECT * FROM Topic WHERE addedby = :id');
    $query->execute(array('id' => $id));
    $rows = $query->fetchAll();
    $topics = array();

    foreach($rows as $row){
      $topics[] = new Topic(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'description' => $row['description'],
        'course' => Course::find($row['course'])
      ));
    }

    return $topics;
  }
  
  public function save(){
    $query = DB::connection()->prepare('INSERT INTO Person (name, addedby, description, course) VALUES (:name, :addedby, :description, :course) RETURNING id');
    $query->execute(array('name' => $this->name, 'addedby' => $this->addedby, 'description' => $this->description, 'course' => $this->course));
    $row = $query->fetch();
    $this->id = $row['id'];
  }
}