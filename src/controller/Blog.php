<?php
/**
 * @file
 * Blog controller.
 */

namespace Playground\controller;

/**
 * Class Blog
 * @package Playground\controller
 */
class Blog {

  // The blog model ob.ject
  private $blog_model;

  // The messages object.
  private $messages;

  public function __construct($blog_model, $messages) {
    $this->blog_model = $blog_model;
    $this->messages = $messages;
  }

  /**
   * Handle the blog action.
   * @param $action
   */
  public function handleBlogAction($action) {
    if (!empty($action)) {

      switch ($action) {

        case 'add-blog-entry':
          $this->addBlogEntry();
          break;

      }

    }
  }


  private function addBlogEntry() {

    if (isset($_POST['submit']) && 'Save' == trim($_POST['submit'])) {

      // @todo security.

      if (isset($_POST['title']) && !empty($_POST['title'])) {
        $blog_title = $_POST['title'];
      }
      else {
        $message = 'Please enter a blog title';
        $this->messages->setMessage($message, 'error');
      }

      if (isset($_POST['body']) && !empty($_POST['body'])) {
        $blog_body = $_POST['body'];
      }
      else {
        $message = 'Please enter a blog body';
        $this->messages->setMessage($message, 'error');
      }

      if (!empty($blog_title) && !empty($blog_body)) {
        // Blog model should save this blog entry.
        $this->blog_model->saveBlogEntry($blog_title, $blog_body);
      }

    }

  }

}