<?php

class Topic extends BaseModel{

  public $id, $name, $persons, $description, $course;

  public function __construct($attributes){
    parent::__construct($attributes);
    $this->validators = array('validate_name', 'validate_description', 'validate_persons', 'validate_course');   
  }
  
  public static function all($page){
    if ($page > 0) {
      $query = DB::connection()->prepare('SELECT * FROM Topic ORDER BY name LIMIT :limit OFFSET :offset');
      $query->execute(array('limit' => 5, 'offset' => 5 * ($page - 1)));
    } else {
      $query = DB::connection()->prepare('SELECT * FROM Topic ORDER BY name');
      $query->execute();
    }
    
    $rows = $query->fetchAll();
    $topics = array();

    foreach($rows as $row){
      $topics[] = new Topic(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'persons' => Person::find_many_persons_with_topic_id($row['id']),
        'description' => $row['description'],
        'course' => Course::find($row['course'])
      ));
    }
    
    return $topics;
  }
   
  public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM Person_Topic pt JOIN Person p ON pt.person = p.id JOIN Topic t ON t.id = pt.topic WHERE topic = :id');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
      $topic = new Topic(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'persons' => Person::find_many_persons_with_topic_id($row['id']),
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
        'description' => $row['description'],
        'persons' => Person::find_many_persons_with_topic_id($row['id']),  
        'course' => Course::find($row['course'])
      ));
    }

    return $topics;
  }
  
  public static function find_by_person($id) {
    $query = DB::connection()->prepare('SELECT * FROM Person_Topic pt JOIN Person p ON pt.person = p.id JOIN Topic t ON t.id = pt.topic WHERE person = :id');
    $query->execute(array('id' => $id));
    $rows = $query->fetchAll();
    $topics = array();

    foreach($rows as $row){
      $topics[] = new Topic(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'persons' => Person::find_many_persons_with_topic_id($row['id']),
        'description' => $row['description'],
        'course' => Course::find($row['course'])
      ));
    }

    return $topics;
  }
 
  public function save(){
    $query = DB::connection()->prepare('INSERT INTO Topic (name, description, course) VALUES (:name, :description, :course) RETURNING id');
    $query->execute(array('name' => $this->name, 'description' => $this->description, 'course' => $this->course));
    $row = $query->fetch();
    $this->id = $row['id'];
    
    $query = DB::connection()->prepare('INSERT INTO Person_Topic (person, topic) VALUES (:person, :topic)');
    
    foreach ($this->persons as $person) {
      $query->execute(array('person' => $person, 'topic' => $this->id)); 
    } 
  }
  
  public function update() {
    $query = DB::connection()->prepare('UPDATE Topic SET name = :name, description = :description, course = :course WHERE id = :id');
    $query->execute(array('id' => $this->id, 'name' => $this->name, 'description' => $this->description, 'course' => $this->course));
    
    $query = DB::connection()->prepare('DELETE FROM Person_Topic WHERE topic = :topic');
    $query->execute(array('topic' => $this->id));
    
    $query = DB::connection()->prepare('INSERT INTO Person_Topic (person, topic) VALUES (:person, :topic)');
    
    foreach ($this->persons as $person) {
      $query->execute(array('person' => $person, 'topic' => $this->id)); 
    }
  }
  
  public function destroy() {
    $query = DB::connection()->prepare('DELETE FROM Topic WHERE id = :id');
    $query->execute(array('id' => $this->id));
  }
  
  public static function count() {
    $query = DB::connection()->prepare('SELECT Count(*) FROM Topic');
    $query->execute();
    $row = $query->fetch(); 
    return $row[0];
  }
  
  public function averageGrade() {
    $credits = Credit::find_by_topic($this->id);      
    $sum = 0;
    $count = 0;    
    
    foreach($credits as $credit) {
        if ($credit->grade > 0) {
            $sum = $sum + $credit->grade;
            $count++;
        }
    }

    if ($count != 0) {
        return $sum / $count;   
    } else {
        return 0;
    }
  }
  
  public function totalCredits() {
    $credits = Credit::find_by_topic($this->id);      
    $count = 0;    
    
    foreach($credits as $credit) {
        if ($credit->grade > 0) {
            $count++;
        }
    }
    
    return $count;
  }
  
  public function interrupted() {
    $credits = Credit::find_by_topic($this->id);      
    $count = 0;    
    
    foreach($credits as $credit) {
        if ($credit->interrupted) {
            $count++;
        }
    }
    
    return $count;
  }

  public function averageTimeSpent() {
    $credits = Credit::find_by_topic($this->id);      
    $sum = 0;
    $count = 0;    
    
    foreach($credits as $credit) {
        if ($credit->enddate > 0) {
            $end = $credit->enddate;
            $start = $credit->startdate;
            $days_between = (strtotime($end) - strtotime($start)) / 86400;
            $sum = $sum + $days_between;
            $count++;
        }
    }
    
    if ($count != 0) {
        return round($sum / $count);   
    } else {
        return 0;
    }
  }
  
  public function validate_name() {
    return $this->validate_string_length('Nimen', $this->name, 2, 50);
  }
  
  public function validate_description() {
    return $this->validate_string_length('Kuvauksen', $this->description, 4, 500);
  }
  
  public function validate_persons() {
    return $this->validate_select('Aiheen vastuuhenkilöt', $this->persons);  
  }
  
  public function validate_course() {
    return $this->validate_select('Aiheen kurssi', $this->course);  
  }
}
