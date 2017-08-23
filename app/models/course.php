<?php

class Course extends BaseModel{

  public $id, $name, $incharge;

  public function __construct($attributes){
    parent::__construct($attributes);
    $this->validators = array('validate_name', 'validate_incharge');
  }
  
  public static function all(){

    $query = DB::connection()->prepare('SELECT * FROM Course ORDER BY name');
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
        'incharge' => Person::find($row['incharge'])
      ));

      return $course;
    }

    return null;
  }
  
  public static function find_by_person($id) {
    $query = DB::connection()->prepare('SELECT * FROM Course WHERE incharge = :id');
    $query->execute(array('id' => $id));
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
  
  public function save(){
    $query = DB::connection()->prepare('INSERT INTO Course (name, incharge) VALUES (:name, :incharge) RETURNING id');
    $query->execute(array('name' => $this->name, 'incharge' => $this->incharge));
    $row = $query->fetch();
    $this->id = $row['id'];
  }
  
  public function update() {
    $query = DB::connection()->prepare('UPDATE Course SET name = :name, incharge = :incharge WHERE id = :id');
    $query->execute(array('id' => $this->id, 'name' => $this->name, 'incharge' => $this->incharge));
  }
  
  public function destroy() {
    $query = DB::connection()->prepare('DELETE FROM Course WHERE id = :id');
    $query->execute(array('id' => $this->id));
  }  
  
  public function validate_name() {
    return $this->validate_string_length('Nimen', $this->name, 2, 50);
  }  
  
  public function validate_incharge() {
    return $this->validate_select('Kurssin vastuuhenkilö', $this->incharge);  
  }
}

