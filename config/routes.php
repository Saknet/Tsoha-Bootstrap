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
  
  $routes->post('/topic', function() {
      TopicController::store();     
  });
  
  $routes->get('/topic/new', function(){
      TopicController::create();    
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
  
  $routes->post('/credit', function() {
      CreditController::store();     
  });
  
  $routes->get('/credit/new', function(){
      CreditController::create();    
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
  
  $routes->post('/person', function() {
      PersonController::store();     
  });
  
  $routes->get('/person/new', function(){
      PersonController::create();    
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
  
  $routes->post('/course', function() {
      CourseController::store();     
  });
  
  $routes->get('/course/new', function(){
      CourseController::create();    
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
