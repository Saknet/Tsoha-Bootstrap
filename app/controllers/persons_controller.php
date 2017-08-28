<?php
/**
 *  Handles requests related to person model.
 */
class PersonController extends BaseController{

  /**
   * Lists all users (persons).
   */     
  public static function index(){
    $persons = Person::all();
    View::make('person/index.html', array('persons' => $persons));
  }
  
  /**
   * Shows a user's (person) view.
   *
   * @param int $id Id of the person.
   */   
  public static function show($id) {
    $person = Person::find($id);
    $topics = Topic::find_by_person($id);
    $courses = Course::find_by_person($id);
    View::make('person/show.html', array('person' => $person, 'topics' => $topics, 'courses' => $courses));
  }

  /**
   * Shows page for new user (person) creation.
   */   
  public static function create() {
    self::check_logged_in();
    View::make('person/new.html');   
  }
  
  /**
   * Attempts to save new user (person) information into database, then redirects to the newly created user's view.
   */    
  public static function store() {
    $params = $_POST;
    
    $attributes = array(
      'name' => $params['name'],
      'username' => $params['username'],
      'password' => $params['password'],
      'verify' => $params['verify']   
    );
    
    $person = new Person($attributes);
    $errors = $person->errors();
    
    if (count($errors) == 0) {
      $person->save();
      Redirect::to('/person/' . $person->id, array('message' => 'Henkilön tiedot lisättiin tietokantaan!'));
    } else {
        View::make('person/new.html', array('errors' => $errors, 'attributes' => $attributes));        
    }
  }

  /**
   * Shows a user (person) edit page.
   *
   * @param int $id Id of a user.
   */  
  public static function edit($id) {
    self::check_admin();
    $person = Person::find($id);
    View::make('person/edit.html', array('attributes' => $person));
  }

  /**
   * Attempts to update a user (person) information, then redirects to edited user's view.
   *
   * @param int $id Id of a user.
   */    
  public static function update($id) {
    $params = $_POST;
    
    if (!isset($params['admin'])) {
      $params['admin'] = null;
    }

    $attributes = array(
      'id' =>  $id,
      'name' => $params['name'],
      'username' => $params['username'],
      'password' => $params['password'],
      'verify' => $params['verify'],  
      'admin' => $params['admin']
    );

    $person = new Person($attributes);
    $errors = $person->errors();

    if (count($errors) > 0){
      View::make('person/edit.html', array('errors' => $errors, 'attributes' => $attributes));
    } else {
      $person->update();

      Redirect::to('/person/' . $person->id, array('message' => 'Henkilön tietoja muokattiin onnistuneesti!'));
    }
  }

  /**
   * Attempts to destroy a user (person) information, then redirects to user listing.
   *
   * @param int $id Id of a user.
   */    
  public static function destroy($id) {
    self::check_admin();
    $person = new Person(array('id' => $id));
    $person->destroy();

    Redirect::to('/person', array('message' => 'Henkiön tiedot poistettiin onnistuneesti!'));
  } 
  
  /**
   * Shows login page.
   */  
  public static function login(){
      View::make('person/login.html');
  }
  
  /**
   * Checks login information, if successful, creates a session for the user.
   */  
  public static function handle_login(){
    $params = $_POST;

    $person = Person::authenticate($params['username'], $params['password']);

    if (!$person){
      View::make('person/login.html', array('message' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
    } else {
      $_SESSION['user'] = $person->id;

      Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $person->name . '!'));
    }
  }
  
  /**
  * Logs out current user, redirects to login page.
  */  
  public static function logout() {
    $_SESSION['user'] = null;
    Redirect::to('/login', array('message' => 'Uloskirjautuminen tapahtui onnistuneesti!'));
  }
}
