<?php
/**
 *  Handles requests related to credits model.
 */
class CreditController extends BaseController{
    
  /**
   * Lists all credits, using paging. 
   */    
  public static function index() {
    if (isset($_GET['page'])){
      $page = preg_replace("#[^0-9]#","",$_GET['page']);                
    } else {
      $page = 1;                      
    }  
    
    $page_size = 10;
    $totalCredits = Credit::count();
    $pages = ceil($totalCredits/$page_size);  
    $credits = Credit::all($page);
    
    if ($page > 1) {
      $prev_page = $page - 1;
    } else {
      $prev_page = 1;
    }
    
    if ($page < $pages) {
      $next_page = $page + 1;
    } else {
      $next_page = $pages; 
    }
    
    View::make('credit/index.html', array('credits' => $credits, 'pages' => $pages, 'prev_page' => $prev_page, 'next_page' => $next_page));
  }
  
  /**
   * Shows a credit's view.
   *
   * @param int $id Id of the credit.
   */   
  public static function show($id) {
    $credit = Credit::find($id);
    View::make('credit/show.html', array('credit' => $credit));
  }
  
  /**
   * Shows page for new credit creation.
   */   
  public static function create() {
    self::check_logged_in();
    $persons = Person::all(-1);
    $topics = Topic::all(-1);
    View::make('credit/new.html', array('persons' => $persons, 'topics' => $topics));   
  }
  
  /**
   * Attempts to save new credit into database, then redirects to the newly created credit's view.
   */  
  public static function store() {
    self::check_logged_in();      
    $params = $_POST;
      
    if (!isset($params['interrupted'])) {
      $params['interrupted'] = null;
    } else {
      $params['grade'] = 0;  
    }
    
    if (!isset($params['givenby'])) {
      $params['givenby'] = null;
    }
    
    if (!isset($params['topic'])) {
      $params['topic'] = null;
    }
      
    $attributes = array(
      'givenby' => $params['givenby'],
      'topic' => $params['topic'],
      'interrupted' => $params['interrupted'],
      'startdate' => $params['startdate'],
      'enddate' => $params['enddate'],
      'grade' => $params['grade']                  
    );

    $credit = new Credit($attributes);    
    $errors = $credit->errors();

    if (count($errors) == 0) {
      $credit->save();
      Redirect::to('/credit/' . $credit->id, array('message' => 'Suorituksen tiedot lisättiin järjestelmään!'));
    } else {
      $persons = Person::all(-1);
      $topics = Topic::all(-1);
      View::make('credit/new.html', array('errors' => $errors, 'attributes' => $attributes, 'persons' => $persons, 'topics' => $topics));
    }
  }
  
  /**
   * Shows credit a edit page.
   *
   * @param int $id Id of a credit.
   */  
  public static function edit($id) {
    self::check_logged_in();      
    $persons = Person::all(-1);
    $topics = Topic::all(-1);
    $credit = Credit::find($id);
    View::make('credit/edit.html', array('attributes' => $credit, 'persons' => $persons, 'topics' => $topics));
  }
  
  /**
   * Attempts to update a credit information, then redirects to edited credit's view.
   *
   * @param int $id Id of a credit.
   */   
  public static function update($id) {
    self::check_logged_in();  
    $params = $_POST;
    
    if (!isset($params['interrupted'])) {
      $params['interrupted'] = null;
    } else {
      $params['grade'] = 0;  
    }
    
    if (!isset($params['givenby'])) {
      $params['givenby'] = null;
    }
    
    if (!isset($params['topic'])) {
      $params['topic'] = null;
    }
    
    $attributes = array(
      'id' =>  $id,
      'givenby' => $params['givenby'],
      'topic' => $params['topic'],
      'interrupted' => $params['interrupted'],
      'startdate' => $params['startdate'],
      'enddate' => $params['enddate'],
      'grade' => $params['grade']     
    );

    $credit = new Credit($attributes);
    $errors = $credit->errors();

    if (count($errors) > 0){
      $persons = Person::all(-1);
      $topics = Topic::all(-1);  
      View::make('credit/edit.html', array('errors' => $errors, 'attributes' => $attributes, 'persons' => $persons, 'topics' => $topics, 'editcheck' => true));
    } else {
      $credit->update();
      Redirect::to('/credit/' . $credit->id, array('message' => 'Suorituksen tietoja muokattiin onnistuneesti!'));
    }
  }

  /**
   * Attempts to destroy a credit, then redirects to credit listing.
   *
   * @param int $id Id of a credit.
   */  
  public static function destroy($id) {
    self::check_logged_in();  
    $credit = new Credit(array('id' => $id));
    $credit->destroy();

    Redirect::to('/credit', array('message' => 'Suoritus poistettiin onnistuneesti!'));
  }
}