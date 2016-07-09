<?php
/**
 * @file
 * User model.
 */

namespace Playground\model;

/**
 * Class User
 * @package Playground\model
 */
class User {

  // variable for the user id.
  public $user_id;
  // The messages object.
  private $messages;
  // The database object.
  private $database;

  /**
   * User constructor.
   * @param $database
   * @param $messages
   */
  public function __construct($database, $messages)
  {
    $this->database = $database;
    $this->messages = $messages;

    // Start a session.
    // @todo just start a session if needed - if possible somehow.
    session_start();

    // Manage the user id.
    // It is stored in the session if the user is logged in.
    $this->manageUserId();
  }

  /**
   * Check if a user is logged in.
   * @return bool
   */
  public function userIsLoggedIn()
  {
    if (!empty($this->user_id)) {
      return TRUE;
    }
    return FALSE;
  }


  /**
   * Handle the user login.
   * @param $username
   * @param $password
   */
  public function login($username, $password) {
    if (!empty($username) && !empty($password)) {
      if ($user_id = $this->verifyLogin($username, $password)) {
        // user is authenticated and can access the backend.
        // Store e the user id in the session for usage in the next request.
        $this->setUserId($user_id);
        $this->storeUserIdInSession($user_id);
      }
    }
  }

  /**
   * Get the user id.
   * @return mixed
   */
  public function getUserId() {
    return $this->user_id;
  }

  /**
   * Set the user id.
   * @param $user_id
   */
  private function setUserId($user_id) {
    $this->user_id = $user_id;
  }

  /**
   * Logout.
   */
  public function logout() {
    $this->removeUserIdFromSession();
    $this->user_id = '';
  }

  /**
   * Manage the user id at the beginning of each request.
   */
  private function manageUserId() {
    if ($user_id =$this->getUserIdFromSession()) {
      $this->setUserId($user_id);
    }
  }


  /**
   * Verify the login.
   * @param $username
   * @param $password
   * @return int
   */
  private function verifyLogin($username, $password) {

    $user_id = 0;

    // @todo security.
    // Select user from database if available.
    $query = 'SELECT user_id ';
    $query .= 'FROM users ';
    $query .= 'WHERE username = "' . $username . '" ';
    $query .= 'AND password = "' . $password . '" ';
    $result = $this->database->execute($query);
    if (!empty($result)) {
      while ($object = $result->fetch_object()) {
        $user_id = $object->user_id;
      }
    }

    if (empty($user_id)) {
      // display error message.
      $message = 'The username and/or password are incorrect.';
      $this->messages->setMessage($message, 'error');
    }

    return $user_id;
  }


  /**
   * Get the user id from the session if the user is already logged in.
   * @return mixed
   */
  private function getUserIdFromSession() {
    if (isset($_SESSION['user']['user_id']) && !empty($_SESSION['user']['user_id'])) {
      return $_SESSION['user']['user_id'];
    }
  }


  /**
   * Store the user id in the session.
   * @param $user_id
   */
  private function storeUserIdInSession($user_id) {
    $_SESSION['user']['user_id'] = $user_id;
  }

  /**
   * Remove the user id from the session.
   */
  private function removeUserIdFromSession() {
    unset($_SESSION['user']['user_id']);
  }


}