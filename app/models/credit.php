<?php

class Topic extends BaseModel{

  public $id, $givenby, $topic_id, $interrupted, $startdate, $enddate, $grade;

  public function __construct($attributes){
    parent::__construct($attributes);
  }
				
  public static function all(){

    $query = DB::connection()->prepare('SELECT * FROM Credit');
    $query->execute();
    $rows = $query->fetchAll();
    $credits = array();

    foreach($rows as $row){
      $credits[] = new Topic(array(
        'id' => $row['id'],
        'givenby' => $row['givenby'],
        'topic_id' => $row['topic_id'],
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
      $credit = new Topic(array(
        'id' => $row['id'],
        'givenby' => $row['givenby'],
        'topic_id' => $row['topic_id'],
        'interrupted' => $row['interrupted'],
        'startdate' => $row['startdate'],
        'enddate' => $row['enddate'],
        'grade' => $row['grade']  
      ));

      return $credit;
    }

    return null;
  }
  
  public function save(){
    $query = DB::connection()->prepare('INSERT INTO Credit (givenby, topic_id, startdate, enddate, grade) VALUES (:givenby, :topic_id, :startdate, :enddate, :grade) RETURNING id');
    $query->execute(array('givenby' => $this->givenby, 'topic_id' => $this->topic_id, 'startdate' => $this->startdate, 'enddate' => $this->enddate, 'grade' => $this->grade));
    $row = $query->fetch();
    $this->id = $row['id'];
  }
}
