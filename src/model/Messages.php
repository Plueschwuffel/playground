<?php
/**
 * @file
 * Messages.
 */

namespace Playground\model;

/**
 * Class Messages
 * @package Playground\model
 */
class Messages {

  // Store the messages.
  private $messages;

  /**
   * Set a message
   * @param $message
   * @param $type
   */
  public function setMessage($message, $type) {
    if (!empty($message) && !empty($type)) {
      $this->messages[$type][] = $message;
    }
  }

  /**
   * Get the messages.
   * @return mixed
   */
  public function getMessages() {
    return $this->messages;
  }

}