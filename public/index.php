<?php

require_once ('../src/controller/autoload.php');

// New database object.
$database = new \Playground\database\Database();
// New messages object.
$messages = new \Playground\model\Messages();
// New user model object.
$user_model = new \Playground\model\User($database, $messages);
// New blog model.
$blog_model = new \Playground\model\Blog();
// New blog controller.
$blog_controller = new \Playground\controller\Blog($blog_model, $messages);
// New user controller object.
$user_controller = new \Playground\controller\User($user_model, $messages);
// New router controller object.
$router = new \Playground\controller\Router($user_controller, $blog_controller);
// New view object.
$view = new \Playground\view\View($user_model, $router, $messages);

$view->displayPage();




