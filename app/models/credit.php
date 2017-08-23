<?php

class Credit extends BaseModel{

  public $id, $givenby, $topic, $interrupted, $startdate, $enddate, $grade;

  public function __construct($attributes){
    parent::__construct($attributes);
    $this->validators = array('validate_startdate', 'validate_enddate', 'validate_grade', 'validate_person', 'validate_topic');    
  }
				
  public static function all($page){
    $query = DB::connection()->prepare('SELECT * FROM Credit LIMIT :limit OFFSET :offset');
    $page_size = 5;
    $query->execute(array('limit' => $page_size, 'offset' => $page_size * ($page - 1)));
    $rows = $query->fetchAll();
    $credits = array();

    foreach($rows as $row){
      $credits[] = new Credit(array(
        'id' => $row['id'],
        'givenby' => Person::find($row['givenby']),
        'topic' => Topic::find($row['topic']),
        'interrupted' => $row['interrupted'],
        'startdate' => $row['startdate'],
        'enddate' => $row['enddate'],
        'grade' => $row['grade']         
      ));
    }

    return $credits;
  }
  
  public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM Credit WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
      $credit = new Credit(array(
        'id' => $row['id'],
        'givenby' => Person::find($row['givenby']),
        'topic' => Topic::find($row['topic']),
        'interrupted' => $row['interrupted'],
        'startdate' => $row['startdate'],
        'enddate' => $row['enddate'],
        'grade' => $row['grade']   
      ));

      return $credit;
    }

    return null;
  }
  
  public static function find_by_topic($id) {
    $query = DB::connection()->prepare('SELECT * FROM Credit WHERE topic = :id');
    $query->execute(array('id' => $id));
    $rows = $query->fetchAll();
    $credits = array();

    foreach($rows as $row){
      $credits[] = new Credit(array(
        'id' => $row['id'],
        'givenby' => Person::find($row['givenby']),
        'topic' => Topic::find($row['topic']),
        'interrupted' => $row['interrupted'],
        'startdate' => $row['startdate'],
        'enddate' => $row['enddate'],
        'grade' => $row['grade']  
      ));
    }

    return $credits;
  }
  
  public function save(){
    $query = DB::connection()->prepare('INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (:givenby, :topic, :interrupted, :startdate, :enddate, :grade) RETURNING id');
    $query->execute(array('givenby' => $this->givenby, 'topic' => $this->topic, 'interrupted' => $this->interrupted, 'startdate' => $this->startdate, 'enddate' => $this->enddate, 'grade' => $this->grade));
    $row = $query->fetch();
    $this->id = $row['id'];
  }
  
  public function update() {
    $query = DB::connection()->prepare('UPDATE Credit SET givenby = :givenby, topic = :topic, interrupted = :interrupted, startdate = :startdate, enddate = :enddate, grade = :grade WHERE id = :id');
    $query->execute(array('id' => $this->id, 'givenby' => $this->givenby, 'topic' => $this->topic, 'interrupted' => $this->interrupted, 'startdate' => $this->startdate, 'enddate' => $this->enddate, 'grade' => $this->grade));
  }
  
  public function destroy() {
    $query = DB::connection()->prepare('DELETE FROM Credit WHERE id = :id');
    $query->execute(array('id' => $this->id));
  }
  
  public static function count() {
    $query = DB::connection()->prepare('SELECT Count(*) FROM Credit');
    $query->execute();
    $row = $query->fetch(); 
    return $row[0];
  }
  
  public function validate_startdate() {
    return $this->validate_date('Aloituspäivämäärän', $this->startdate);
  }
  
  public function validate_enddate() {
    return $this->validate_date('Lopetuspäivämäärän', $this->enddate);
  }
  
  public function validate_grade() {
      return $this->validate_number($this->grade);  
  }
  
  public function validate_person() {
    return $this->validate_select('Arvioija', $this->givenby);  
  }
  
  public function validate_topic() {
    return $this->validate_select('Aihe', $this->topic);  
  }
}
