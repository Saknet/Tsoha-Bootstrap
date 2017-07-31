<?php

  $routes->get('/', function() {
    HelloWorldController::login();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/topic', function() {
      HelloWorldController::topic_list();
  });
  
  $routes->get('/topic/1', function() {
      HelloWorldController::topic_show();     
  });
  
  $routes->get('/topic/edit/1', function() {
      HelloWorldController::topic_edit();     
  });
  
  $routes->get('/credit', function() {
      HelloWorldController::credit_list();
  });
  
  $routes->get('/credit/1', function() {
      HelloWorldController::creditc_show();     
  });
  
  $routes->get('/credit/edit/1', function() {
      HelloWorldController::credit_edit();     
  });
  
  $routes->get('/person', function() {
      HelloWorldController::person_list();
  });
  
  $routes->get('/person/1', function() {
      HelloWorldController::person_show();     
  });
  
  $routes->get('/person/edit/1', function() {
      HelloWorldController::person_edit();     
  });

  $routes->get('/login', function() {
      HelloWorldController::login();
  });
