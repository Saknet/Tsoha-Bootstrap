<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
        $errors = array_merge($errors, $this->{$validator}());
      }

      return $errors;
    }
    
    public function validate_string_length($value, $string, $minLength, $maxLength) {
      $errors = array();
      
      if($string == '' || $string == null){
        $errors[] = $value . ' tulee olla ei tyhjä merkkijono!';
      }
      if(!is_string($string)) {
        $errors[] = $value . ' tulee olla merkkijono.';
      }
      if(strlen($string) < $minLength) {
        $errors[] = $value . ' pituuden tulee olla vähintään ' . $minLength . ' merkkiä!';
      }
      if(strlen($string) > $maxLength) {
        $errors[] = $value . ' pituuden tulee olla enintään ' . $maxLength . ' merkkiä!';
      }
      return $errors;
    }
    
    public function validate_date($value, $date) {
      $errors = array();
      if (!($date == date('Y-m-d', strtotime($date)))) {
        $errors[] = $value . ' tulee olla päivämäärä!';       
      }
      return $errors;
    }
    
    public function validate_number($grade) {
      $errors = array(); 
        if(!is_numeric($grade) || $grade < 0 || $grade > 5){
          $errors[] = 'Arvosanan tulee olla kokonaisluku väliltä 0 - 5';
      }
      return $errors;
    }
    
    public function validate_topic_persons($persons) {
      $errors = array();
      if ($persons == null) {
          $errors[] = 'Aiheella tulee olla vähintään yksi vastuunhenkilö';      
      }
      return $errors;
    }
}
