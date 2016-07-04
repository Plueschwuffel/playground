<?php
/**
 * @file
 * Router
 */

namespace Playground\controller;

/**
 * Class Router
 * @package Playground\controller
 */
class Router {

  // Variable for the current action
  public $action;

  // The user model object
  private $user_controller;

  // The blog controller object.
  private $blog_controller;


  /**
   * Router constructor.
   * @param $user_controller
   * @param $blog_controller
   */
  public function __construct($user_controller, $blog_controller)
  {
    $this->user_controller = $user_controller;
    $this->blog_controller = $blog_controller;
    $this->manageAction();
  }


  /**
   * Manage the action logic.
   */
  private function manageAction() {
    $this->setAction();

    switch ($this->action) {

      case 'login':
      case 'logout':
        $this->user_controller->handleUserAction($this->action);
        break;

      case 'add-blog-entry':
        $this->blog_controller->handleBlogAction($this->action);
        break;

      default:

        break;

    }

  }

  /**
   * Set the current action.
   */
  private function setAction() {
    $action = $this->getAction();
    $this->action = $action;
  }


  /**
   * Get the current action.
   * @return mixed
   */
  private function getAction() {
    if (isset($_GET['action']) && !empty($_GET['action'])) {
      // @todo add security check.
      return $_GET['action'];
    }
  }
  



}