<?php
/**
* Model class for persons.
*/
class Person extends BaseModel{

  public $id, $name, $username, $password, $admin, $verify;

  /**
  * Constructor for person.
  */    
  public function __construct($attributes){
    parent::__construct($attributes);
    $this->validators = array('validate_name', 'validate_username', 'validate_unique_username', 'validate_password_length', 'validate_password_verify');
  }
  
  /**
  * Fetches all persons from database.
  *  
  * @param int $page current page number, negative value means that paging is not used. 
  *  
  * @return array A list of all persons from database.
  */    
  public static function all($page){
    if ($page > 0) {
      $page_size = 10;  
      $query = DB::connection()->prepare('SELECT * FROM Person ORDER BY username LIMIT :limit OFFSET :offset');
      $query->execute(array('limit' => $page_size, 'offset' => $page_size * ($page - 1)));
    } else {
      $query = DB::connection()->prepare('SELECT * FROM Person ORDER BY username');
      $query->execute();
    }
    
    $rows = $query->fetchAll();
    $courses = array();

    foreach($rows as $row){
      $persons[] = new Person(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'username' => $row['username'],
        'password' => $row['password'],
        'admin' => $row['admin']
      ));
    }

    return $persons;
  }
  
  /**
  * Fetches one person from database.
  *
  * @param int $id Id of a person.
  *
  * @return Person Person to be fetched or null if person is not found.
  */  
  public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM Person WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
      $person = new Person(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'username' => $row['username'],
        'password' => $row['password'],
        'admin' => $row['admin']
      ));

      return $person;
    }

    return null;
  }
  
  /**
  * Fetches all persons linked with junction table to a topic.
  *
  * @param int $id Id of required topic.
  *
  * @return array Array of all persons linked to a topic.
  */  
  public static function find_many_persons_with_topic_id($id) {
    $query = DB::connection()->prepare('SELECT * FROM Person_Topic pt JOIN Topic t ON t.id = pt.topic JOIN Person p ON pt.person = p.id WHERE topic = :id');
    $query->execute(array('id' => $id));
    $rows = $query->fetchAll();
    $persons = array();

    foreach($rows as $row){
      $persons[] = new Person(array(
        'id' => $row['id'],
        'name' => $row['name'],
        'username' => $row['username'],
        'password' => $row['password'],
        'admin' => $row['admin']
      ));
    }

    return $persons;   
  }

  /**
  * Saves person to database.
  */   
  public function save(){
    $query = DB::connection()->prepare('INSERT INTO Person (name, username, password, admin) VALUES (:name, :username, :password, :admin) RETURNING id');
    $query->execute(array('name' => $this->name, 'username' => $this->username, 'password' => $this->password, 'admin' => $this->admin));
    $row = $query->fetch();
    $this->id = $row['id'];
  }

  /**
  * Updates person information into database.
  */    
  public function update() {
    $query = DB::connection()->prepare('UPDATE Person SET name = :name, username = :username, password = :password, admin = :admin WHERE id = :id');
    $query->execute(array('id' => $this->id, 'name' => $this->name, 'username' => $this->username, 'password' => $this->password, 'admin' => $this->admin));
  }
  
  /**
  * Deletes person from database.
  */  
  public function destroy() {
    $query = DB::connection()->prepare('DELETE FROM Person WHERE id = :id');
    $query->execute(array('id' => $this->id));
  }
  
  /**
  * Counts total number of persons in database.
  *
  * @return integer First element of an query array, contains a count of all persons in database.
  */   
  public static function count() {
    $query = DB::connection()->prepare('SELECT Count(*) FROM Person');
    $query->execute();
    $row = $query->fetch(); 
    return $row[0];
  }  

  /**
  * Checks if password belongs to username.
  *
  * @param String $username Username of person authenticating.
  * @param String $password Password of person authenticating.
  *
  * @return Person If authentication was successful returns person, else returns null.
  */  
  public static function authenticate($username, $password) {
    $query = DB::connection()->prepare('SELECT * FROM Person WHERE username = :username LIMIT 1');
    $query->execute(array('username' => $username));
    $row = $query->fetch();
    
    if($row && $password == $row['password']) {
      $person = new Person(array(
      'id' => $row['id'],
      'name' => $row['name'],
      'username' => $row['username'],
      'password' => $row['password'],
      'admin' => $row['admin']
    ));
    
    return $person;
    
    } else {
      return null;
    }
  } 
 
  /**
  * Makes an array containing all usernames of all persons in database.
  * 
  * @return array Array of all persons usernames. 
  */   
  public function get_all_usernames() {
    $persons = self::all();
    $usernames = array();
    foreach($persons as $person) {
      if ($person->id != $this->id) { 
        array_push($usernames, $person->username);          
      }  
    }
    
    return $usernames;
  }
  
  /**
  * Validations for name of person.
  */  
  public function validate_name() {
    return $this->validate_string_length('Nimen', $this->name, 2, 50);
  }
  
  /**
  * Validations for username of person.
  */    
  public function validate_username() {
    return $this->validate_string_length('Käyttäjätunnuksen', $this->username, 2, 50);
  }
  
  /**
  * Validations for uniqueness of person's username.
  */    
  public function validate_unique_username() {
    return $this->validate_unique($this->username, self::get_all_usernames());
  }
  
  /**
  * Validations for password length of person.
  */    
  public function validate_password_length() {
    return $this->validate_string_length('Salasanan', $this->password, 2, 50);
  } 
  
  /**
  * Validations for password verification of person.
  */    
  public function validate_password_verify() {
    return $this->validate_password($this->password, $this->verify);
  }
}
