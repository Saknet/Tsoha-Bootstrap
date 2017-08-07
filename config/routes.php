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
  
  $routes->get('/topic/:id', function($id) {
      TopicController::show($id);     
  });
  
  $routes->get('/topic/edit/1', function() {
      HelloWorldController::topic_edit();     
  });
  
  $routes->get('/credit', function() {
      CreditController::index();
  });
  
  $routes->get('/credit/:id', function($id) {
      CreditController::show($id);     
  });
  
  $routes->get('/credit/edit/1', function() {
      HelloWorldController::credit_edit();     
  });
  
  $routes->get('/person', function() {
      PersonController::index();
  });
  
  $routes->get('/person/:id', function($id) {
      PersonController::show($id);     
  });

  $routes->get('/person/edit/1', function() {
      HelloWorldController::person_edit();     
  });
  
  $routes->get('/course', function() {
      CourseController::index();
  });
  
  $routes->get('/course/:id', function($id) {
      CourseController::show($id);     
  });
  
  $routes->get('/course/edit/1', function() {
      HelloWorldController::course_edit();     
  });

  $routes->get('/login', function() {
      HelloWorldController::login();
  });
