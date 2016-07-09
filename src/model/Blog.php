<?php
/**
 * @file
 * Blog model.
 */

namespace Playground\model;

/**
 * Class Blog
 * @package Playground\model
 */
class Blog {

  // Store the blog entry list.
  public $blog_list;

  // Store the current selected blog entry.
  public $current_blog_entry;

  // The user model object.
  private $user_model;

  // The database object.
  private $database;

  // The messages object.
  private $messages;

  /**
   * Blog constructor.
   * @param $user_model
   * @param $database
   * @param $messages
   */
  public function __construct($user_model, $database, $messages) {
    $this->user_model = $user_model;
    $this->database = $database;
    $this->messages = $messages;
  }


  /**
   * Set the blog entry list for the usage in the template.
   */
  public function setBlogEntryList() {
    $this->blog_list = $this->getBlogEntries();
  }


  /**
   * Set the current selected blog entry.
   * @param $blog_id
   * @throws \Exception
   */
  public function setBlogEntryByBlogId($blog_id) {
    $this->current_blog_entry = $this->getBlogEntryByBlogId($blog_id);
  }

  /**
   * Save a blog entry.
   * @param $blog_title
   * @param $blog_body
   * @param $blog_id
   * @return $blog_id
   */
  public function saveBlogEntry($blog_title, $blog_body, $blog_id = FALSE) {
    if (!empty($blog_title) && !empty($blog_body)) {
      // Get the user id.
      $user_id = $this->user_model->getUserId();
      // If a blog id is given.
      if (!empty($blog_id)) {
        // Update the blog entry.
        $this->updateBlogEntry($blog_id, $user_id, $blog_title, $blog_body);
      }
      else {
        // Insert a new blog entry.
        $blog_id = $this->insertBlogEntry($user_id, $blog_title, $blog_body);
      }
      return $blog_id;
    }
  }


  /**
   * Get all blog entries.
   */
  private function getBlogEntries() {

    // @todo add pager with limit statement.

    $blog_entries = array();
    $query = 'SELECT be.blog_id, be.title, be.body, be.user_id, be.created, be.modified, u.username ';
    $query .= 'FROM blog_entries be ';
    $query .= 'JOIN users u ON u.user_id = be.user_id ';
    $result = $this->database->execute($query);
    if (!empty($result)) {
      while ($blog_entry = $result->fetch_object()) {
        // @todo create teaser view with shortend text.
        $blog_entries[$blog_entry->blog_id] = $blog_entry;
      }
    }
    return $blog_entries;
  }


  /**
   * Get a single blog entry by it's blog id.
   * @param $blog_id
   * @return mixed
   * @throws \Exception
   */
  private function getBlogEntryByBlogId($blog_id) {
    if (!empty($blog_id) && is_numeric($blog_id)) {
      $query = 'SELECT be.blog_id, be.title, be.body, be.user_id, be.created, be.modified, u.username ';
      $query .= 'FROM blog_entries be ';
      $query .= 'JOIN users u ON u.user_id = be.user_id ';
      $query .= 'WHERE blog_id = ' . $this->database->escapeString($blog_id);
      $result = $this->database->execute($query);
      if (!empty($result)) {
        $blog_entry = $result->fetch_object();
      }
      if (empty($blog_entry)) {
        throw new \Exception('Error -  get blog entry with blog id ' . $blog_id . ' failed');
      }
    }
    return $blog_entry;
  }


  /**
   * Insert a new blog entry.
   * @param $user_id
   * @param $blog_title
   * @param $blog_body
   * @throws \Exception
   */
  private function insertBlogEntry($user_id, $blog_title, $blog_body) {
    if (!empty($blog_title) && !empty($blog_body) && !empty($user_id)) {
      $query = 'INSERT INTO blog_entries ';
      $query .= 'SET title = "' . $this->database->escapeString($blog_title) . '", ';
      $query .= 'body = "' . $this->database->escapeString($blog_body) . '", ';
      $query .= 'user_id = "' . $this->database->escapeString($user_id) . '", ';
      $query .= 'created = "' . time() . '", ';
      $query .= 'modified = "' . time() . '" ';
      $result = $this->database->execute($query);
      if (empty($result)) {
        throw new \Exception('Error - insert of blog entry failed.');
      }
      else {
        // Get the blog id of this new entry.
        $blog_id = $this->database->lastInsertId();
        // @todo is not displayed because of header location redirect.
        $this->messages->setMessage('The blog entry ' . $blog_title . ' has been successfully saved with the id ' . $blog_id . '.', 'success');
      }
      return $blog_id;
    }
  }


  /**
   * Update a blog entry.
   * @param $blog_id
   * @param $user_id
   * @param $blog_title
   * @param $blog_body
   * @throws \Exception
   */
  private function updateBlogEntry($blog_id, $user_id, $blog_title, $blog_body) {
    if (!empty($blog_id) && is_numeric($blog_id)) {
      if (!empty($user_id) && !empty($blog_title) && !empty($blog_body)) {
        $query = 'UPDATE blog_entries ';
        $query .= 'SET title = "' . $this->database->escapeString($blog_title) . '", ';
        $query .= 'body = "' . $this->database->escapeString($blog_body) . '", ';
        $query .= 'user_id = "' . $this->database->escapeString($user_id) . '", ';
        $query .= 'created = "' . time() . '", ';
        $query .= 'modified = "' . time() . '" ';
        $query .= 'WHERE blog_id = ' . $this->database->escapeString($blog_id);
        $result = $this->database->execute($query);
        if (empty($result)) {
          throw new \Exception('Error - update of blog entry failed.');
        }
        else {
          // @todo is not displayed because of header location redirect.
          $this->messages->setMessage('The blog entry ' . $blog_title . ' has been successfully been updated.', 'success');
        }
      }
    }
  }

}