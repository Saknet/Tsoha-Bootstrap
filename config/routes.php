<?php

  $routes->get('/', function() {
    PersonController::login();
  });
  
  $routes->post('/logout', function(){
    PersonController::logout();
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
  
  $routes->get('/topic/:id/edit', function($id){
    TopicController::edit($id);
  });
  
  $routes->post('/topic/:id/edit', function($id){
    TopicController::update($id);
  });

  $routes->post('/topic/:id/destroy', function($id){
    TopicController::destroy($id);
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
  
  $routes->get('/credit/:id/edit', function($id){
    CreditController::edit($id);
  });
  
  $routes->post('/credit/:id/edit', function($id){
    CreditController::update($id);
  });

  $routes->post('/credit/:id/destroy', function($id){
    CreditController::destroy($id);
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

  $routes->get('/person/:id/edit', function($id){
    PersonController::edit($id);
  });
  
  $routes->post('/person/:id/edit', function($id){
    PersonController::update($id);
  });

  $routes->post('/person/:id/destroy', function($id){
    PersonController::destroy($id);
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
  
  $routes->get('/course/:id/edit', function($id){
    CourseController::edit($id);
  });
  
  $routes->post('/course/:id/edit', function($id){
    CourseController::update($id);
  });

  $routes->post('/course/:id/destroy', function($id){
    CourseController::destroy($id);
  });

  $routes->get('/login', function() {
    PersonController::login();
  });
  
  $routes->post('/login', function() {
    PersonController::handle_login();
  });
