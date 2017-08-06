<?php

class Person extends BaseModel{

  public $id, $name, $username, $password, $admin;

  public function __construct($attributes){
    parent::__construct($attributes);
  }
  
  public static function all(){

    $query = DB::connection()->prepare('SELECT * FROM Person');
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
  
  public function save(){
    $query = DB::connection()->prepare('INSERT INTO Person (name, username, password) VALUES (:name, :username, :password) RETURNING id');
    $query->execute(array('name' => $this->name, 'username' => $this->username, 'password' => $this->password));
    $row = $query->fetch();
    $this->id = $row['id'];
  }
}

