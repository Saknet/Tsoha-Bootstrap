<?php
/**
* Model class for topics.
*/
class Topic extends BaseModel{

  public $id, $name, $persons, $description, $course;

  /**
  * Constructor for topic.
  */  
  public function __construct($attributes){
    parent::__construct($attributes);
    $this->validators = array('validate_name', 'validate_description', 'validate_persons', 'validate_course');   
  }

  /**
  * Fetches all topics from database.
  *  
  * @param int $page current page number, negative value means that paging is not used. 
  *
  * @return array A list of all topics from database.
  */   
  public static function all($page){
    if ($page > 0) {
      $page_size = 10;  
      $query = DB::connection()->prepare('SELECT * FROM Topic ORDER BY name LIMIT :limit OFFSET :offset');
      $query->execute(array('limit' => $page_size, 'offset' => $page_size * ($page - 1)));
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
   
  /**
  * Fetches one topic from database.
  *
  * @param int $id Id of topic to be fetched.
  *
  * @return Topic Topic to be fetched or null if topic is not found.
  */   
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
  
  /**
  * Fetches all topics belonging to a course.
  *
  * @param int $id Id of required course.
  *
  * @return array Array of all topics belonging to a course.
  */  
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
  
  /**
  * Fetches all topics linked with junction table to a person.
  *
  * @param int $id Id of required topic.
  *
  * @return array Array of all topics linked to a person.
  */   
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

  /**
  * Saves topic to database.
  */    
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
  
  /**
  * Updates topic information into database.
  */  
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
  
  /**
  * Deletes topic from database.
  */   
  public function destroy() {
    $query = DB::connection()->prepare('DELETE FROM Topic WHERE id = :id');
    $query->execute(array('id' => $this->id));
  }
  
  /**
  * Counts total number of topics in database.
  *
  * @return integer First element of an query array, contains a count of all topic in database.
  */   
  public static function count() {
    $query = DB::connection()->prepare('SELECT Count(*) FROM Topic');
    $query->execute();
    $row = $query->fetch(); 
    return $row[0];
  }
  
  /**
  * Calculates average of the topic's credits grades.
  *
  * @return int Average grade, 0 if topic has no passing grades.
  */   
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
  
  /**
  * Calculates how many of the topic's credits have passed (> 0).
  *
  * @return int Passed.
  */   
  public function totalPassed() {
    $credits = Credit::find_by_topic($this->id);      
    $passed = 0;    
    
    foreach($credits as $credit) {
      if ($credit->grade > 0) {
        $passed++;
      }
    }
    
    return $passed;
  }
  
  /**
  * Calculates how many of the topic's credits have been interrupted.
  *
  * @return int Count.
  */ 
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

  /**
  * Calculates the average time students have spent on topic.
  *
  * @return int Time spent on topic, 0 if topic has no credits with enddate.
  */   
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
  
  /**
  * Calculates the average time students have spent on topic.
  *
  * @return int Dropout rate, 0 if topic has no credits.
  */    
  public function dropOutRate() {
    $credits = Credit::find_by_topic($this->id);    
    
    if ($credits) {
      $dropouts = self::interrupted();
      return round(count($dropouts) / count($credits) * 100);
    } else {
      return 0;  
    }
  }
 
  /**
  * Validations for name of topic.
  */   
  public function validate_name() {
    return $this->validate_string_length('Nimen', $this->name, 2, 50);
  }

  /**
  * Validations for description of topic.
  */   
  public function validate_description() {
    return $this->validate_string_length('Kuvauksen', $this->description, 4, 500);
  }
  
  /**
  * Validations for persons in charge select of topic.
  */   
  public function validate_persons() {
    return $this->validate_select('Aiheen vastuuhenkilöt', $this->persons);  
  }
  
  /**
  * Validations for course select of topic.
  */   
  public function validate_course() {
    return $this->validate_select('Aiheen kurssi', $this->course);  
  }
}
