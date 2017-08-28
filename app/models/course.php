<?php
/**
* Model class for courses.
*/
class Course extends BaseModel{

  public $id, $name, $incharge;

  /**
  * Constructor for course.
  */  
  public function __construct($attributes){
    parent::__construct($attributes);
    $this->validators = array('validate_name', 'validate_incharge');
  }
  
  /**
  * Fetches all courses from database.
  *
  * @return array A list of all courses from database.
  */  
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

  /**
  * Fetches one course from database.
  *
  * @param int $id Id of a course.
  *
  * @return Course Course to be fetched or null if coure is not found.
  */  
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
   
  /**
  * Fetches all courses managed by a person.
  *
  * @param int $id Id of required person.
  *
  * @return array Array of all courses managed by a person.
  */
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
  
  /**
  * Saves course to database.
  */  
  public function save(){
    $query = DB::connection()->prepare('INSERT INTO Course (name, incharge) VALUES (:name, :incharge) RETURNING id');
    $query->execute(array('name' => $this->name, 'incharge' => $this->incharge));
    $row = $query->fetch();
    $this->id = $row['id'];
  }

  /**
  * Updates course information into database.
  */
  public function update() {
    $query = DB::connection()->prepare('UPDATE Course SET name = :name, incharge = :incharge WHERE id = :id');
    $query->execute(array('id' => $this->id, 'name' => $this->name, 'incharge' => $this->incharge));
  }

  /**
  * Deletes course from database.
  */  
  public function destroy() {
    $query = DB::connection()->prepare('DELETE FROM Course WHERE id = :id');
    $query->execute(array('id' => $this->id));
  }  

  /**
  * Validations for name of course.
  */  
  public function validate_name() {
    return $this->validate_string_length('Nimen', $this->name, 2, 50);
  }  
  
  /**
  * Validations for person in charge select of course.
  */  
  public function validate_incharge() {
    return $this->validate_select('Kurssin vastuuhenkilö', $this->incharge);  
  }
}

