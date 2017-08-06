<?php

class Course extends BaseModel{

  public $id, $name, $incharge;

  public function __construct($attributes){
    parent::__construct($attributes);
  }
  
  public static function all(){

    $query = DB::connection()->prepare('SELECT * FROM Course');
    $query->execute();
    $rows = $query->fetchAll();
    $courses = array();

    foreach($rows as $row){
      $courses[] = new Course(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'incharge' => Person::find($row['incharge'])
      ));
    }

    return $courses;
  }
  
  public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM Course WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
      $course = new Course(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'incharge' => $row['incharge']
      ));

      return $course;
    }

    return null;
  }
  
  public function save(){
    $query = DB::connection()->prepare('INSERT INTO Course (name, incharge) VALUES (:name, :incharge) RETURNING id');
    $query->execute(array('name' => $this->name, 'incharge' => $this->incharge));
    $row = $query->fetch();
    $this->id = $row['id'];
  }
}

