<?php

  $routes->get('/', function() {
    HelloWorldController::login();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/topic', function() {
      TopicController::index();
  });
  
  $routes->get('/topic/1', function() {
      HelloWorldController::topic_show();     
  });
  
  $routes->get('/topic/edit/1', function() {
      HelloWorldController::topic_edit();     
  });
  
  $routes->get('/credit', function() {
      CreditController::index();
  });
  
  $routes->get('/credit/1', function() {
      HelloWorldController::credit_show();     
  });
  
  $routes->get('/credit/edit/1', function() {
      HelloWorldController::credit_edit();     
  });
  
  $routes->get('/person', function() {
      PersonController::index();
  });
  
  $routes->get('/person/1', function() {
      HelloWorldController::person_show();     
  });
  
  $routes->get('/person/edit/1', function() {
      HelloWorldController::person_edit();     
  });
  
  $routes->get('/course', function() {
      CourseController::index();
  });
  
  $routes->get('/course/1', function() {
      HelloWorldController::course_show();     
  });
  
  $routes->get('/course/edit/1', function() {
      HelloWorldController::course_edit();     
  });

  $routes->get('/login', function() {
      HelloWorldController::login();
  });
