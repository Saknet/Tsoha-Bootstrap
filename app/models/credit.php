<?php
/**
* Model class for credits.
*/
class Credit extends BaseModel{

  public $id, $givenby, $topic, $interrupted, $startdate, $enddate, $grade;

  /**
  * Constructor for credit.
  */   
  public function __construct($attributes){
    parent::__construct($attributes);
    $this->validators = array('validate_startdate', 'validate_enddate', 'validate_grade', 'validate_person', 'validate_topic');    
  }

  /**
  * Fetches all credits from database.
  *  
  * @param int $page current page number, used for paging.
  * 
  * @return array A list of all credits from database.
  */   
  public static function all($page){
    $query = DB::connection()->prepare('SELECT * FROM Credit LIMIT :limit OFFSET :offset');
    $page_size = 10;
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
  
  /**
  * Fetches one credit from database.
  *
  * @param int $id Id of credit.
  *
  * @return Credit Credit to be fetched or null if credit is not found.
  */   
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

  /**
  * Fetches all credits belonging to a topic.
  *
  * @param int $id Id of required topic.
  *
  * @return array Array of all credits beloning to a topic.
  */
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

  /**
  * Saves credit to database.
  */   
  public function save(){
    $query = DB::connection()->prepare('INSERT INTO Credit (givenby, topic, interrupted, startdate, enddate, grade) VALUES (:givenby, :topic, :interrupted, :startdate, :enddate, :grade) RETURNING id');
    $query->execute(array('givenby' => $this->givenby, 'topic' => $this->topic, 'interrupted' => $this->interrupted, 'startdate' => $this->startdate, 'enddate' => $this->enddate, 'grade' => $this->grade));
    $row = $query->fetch();
    $this->id = $row['id'];
  }

  /**
  * Updates credit information into database.
  */  
  public function update() {
    $query = DB::connection()->prepare('UPDATE Credit SET givenby = :givenby, topic = :topic, interrupted = :interrupted, startdate = :startdate, enddate = :enddate, grade = :grade WHERE id = :id');
    $query->execute(array('id' => $this->id, 'givenby' => $this->givenby, 'topic' => $this->topic, 'interrupted' => $this->interrupted, 'startdate' => $this->startdate, 'enddate' => $this->enddate, 'grade' => $this->grade));
  }
  
  /**
  * Deletes credit from database.
  */  
  public function destroy() {
    $query = DB::connection()->prepare('DELETE FROM Credit WHERE id = :id');
    $query->execute(array('id' => $this->id));
  }
  
  /**
  * Counts total number of credits in database.
  *
  * @return int First element of an query array, contains a count of all credits in database.
  */ 
  public static function count() {
    $query = DB::connection()->prepare('SELECT Count(*) FROM Credit');
    $query->execute();
    $row = $query->fetch(); 
    return $row[0];
  }
  
  /**
  * Validations for startdate of credit.
  */  
  public function validate_startdate() {
    return $this->validate_date('Aloituspäivämäärän', $this->startdate);
  }
  
  /**
  * Validations for enddate of credit.
  */  
  public function validate_enddate() {
    return $this->validate_date('Lopetuspäivämäärän', $this->enddate);
  }
 
  /**
  * Validations for grade of credit.
  */    
  public function validate_grade() {
      return $this->validate_number($this->grade);  
  }
 
  /**
  * Validations for person select of credit.
  */  
  public function validate_person() {
    return $this->validate_select('Arvioija', $this->givenby);  
  }
 
  /**
  * Validations for topic select of credit.
  */    
  public function validate_topic() {
    return $this->validate_select('Aihe', $this->topic);  
  }
}
