<?php

class Person extends BaseModel{

  public $id, $name, $username, $password, $admin;

  public function __construct($attributes){
    parent::__construct($attributes);
    $this->validators = array('validate_name', 'validate_username', 'validate_password');
  }
  
  public static function all(){

    $query = DB::connection()->prepare('SELECT * FROM Person ORDER BY name');
    $query->execute();
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
   
  public function save(){
    $query = DB::connection()->prepare('INSERT INTO Person (name, username, password) VALUES (:name, :username, :password) RETURNING id');
    $query->execute(array('name' => $this->name, 'username' => $this->username, 'password' => $this->password));
    $row = $query->fetch();
    $this->id = $row['id'];
  }
  
  public function update() {
    $query = DB::connection()->prepare('UPDATE Person SET name = :name, username = :username, password = :password, admin = :admin WHERE id = :id');
    $query->execute(array('id' => $this->id, 'name' => $this->name, 'username' => $this->username, 'password' => $this->password, 'admin' => $this->admin));
  }
  
  public function destroy() {
    $query = DB::connection()->prepare('DELETE FROM Person WHERE id = :id');
    $query->execute(array('id' => $this->id));
  }
  
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
  
  public function validate_name() {
    return $this->validate_string_length('Nimen', $this->name, 2, 50);
  }
  
  public function validate_username() {
    return $this->validate_string_length('Käyttäjätunnuksen', $this->username, 2, 50);
  }
  
  public function validate_password() {
    return $this->validate_string_length('Salasanan', $this->password, 2, 50);
  } 
}
