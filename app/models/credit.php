<?php

class Credit extends BaseModel{

  public $id, $givenby, $topic, $interrupted, $startdate, $enddate, $grade;

  public function __construct($attributes){
    parent::__construct($attributes);
  }
				
  public static function all(){

    $query = DB::connection()->prepare('SELECT * FROM Credit');
    $query->execute();
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
}
