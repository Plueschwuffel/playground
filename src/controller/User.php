<?php
/**
 * @file
 * User controller.
 */

namespace Playground\controller;

use Playground\settings\Settings;

/**
 * Class User
 * @package Playground\controller
 */
class User {

  // the user model object.
  private $user_model;

  // the messages object.
  private $messages;


  /**
   * User constructor.
   * @param $user_model
   * @param $messages
   */
  public function __construct($user_model, $messages) {
    $this->user_model = $user_model;
    $this->messages = $messages;
  }


  /**
   * Handle a user action.
   * @param $action
   */
  public function handleUserAction($action) {

    if (!empty($action)) {

      switch ($action) {

        case 'login':
          if (!$this->user_model->userIsLoggedIn()) {
            $this->userLogin();
          }
          break;

        case 'logout':
          if ($this->user_model->userIsLoggedIn()) {
            $this->userLogout();
          }
          break;

      }

    }
  }


  /**
   * Handle the user login.
   */
  private function userLogin() {

    if (isset($_POST['submit']) && 'Login' == trim($_POST['submit'])) {
      if (isset($_POST['username']) && !empty($_POST['username'])) {
        $username = trim($_POST['username']);
      }
      if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = trim($_POST['password']);
      }

      if (!empty($username) && !empty($password)) {
        $this->user_model->login($username, $password);
      }
      else {
        // No username and password is set.
        $message = 'Bitte geben Sie den Namen und das Passwort ein.';
        $this->messages->setMessage($message, 'error');
      }

      // If the user is logged in now redirect him to the startpage.
      if ($this->user_model->userIsLoggedIn()) {
        $settings = new Settings();
        header('Location: ' . $settings->protocol . $settings->domain , 1);
      }
    }
  }

  /**
   * User logout.
   */
  private function userLogout() {
    $this->user_model->logout();
  }

}