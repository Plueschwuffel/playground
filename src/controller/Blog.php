<?php
/**
 * @file
 * Blog controller.
 */

namespace Playground\controller;

use Playground\settings\Settings;

/**
 * Class Blog
 * @package Playground\controller
 */
class Blog {

  // The blog model ob.ject
  private $blog_model;

  // The messages object.
  private $messages;

  /**
   * Blog constructor.
   * @param $blog_model
   * @param $messages
   */
  public function __construct($blog_model, $messages) {
    $this->blog_model = $blog_model;
    $this->messages = $messages;
  }

  /**
   * Handle the blog action.
   * @param $action
   */
  public function handleBlogAction($action) {

    switch ($action) {

      // Add a new blog entry.
      case 'add-blog-entry':
        $this->addBlogEntry();
        break;

      // Edit an existing blog entry.
      case 'edit-blog-entry':
        $this->editBlogEntry();
        break;

      // Display the blog detail page.
      case 'blog-detail':
        if (isset($_GET['id']) && !empty($_GET['id'])) {
          // @todo security.
          $blog_id = $_GET['id'];
          $this->blog_model->setBlogEntryByBlogId($blog_id);
        }
        break;

      // List the blog entries.
      default:
        $this->blog_model->setBlogEntryList();
        break;

    }

  }


  /**
   * Add a new blog entry.
   */
  private function addBlogEntry() {

    if (isset($_POST['submit']) && 'Save' == trim($_POST['submit'])) {

      // @todo security.

      // Get the blog title from the post variables.
      if (isset($_POST['title']) && !empty($_POST['title'])) {
        $blog_title = $_POST['title'];
      }
      else {
        // Display a message if no title is given.
        $message = 'Please enter a blog title';
        $this->messages->setMessage($message, 'error');
      }

      // Get the blog body from the post variables.
      if (isset($_POST['body']) && !empty($_POST['body'])) {
        $blog_body = $_POST['body'];
      }
      else {
        // Display a message if no body is given.
        $message = 'Please enter a blog body';
        $this->messages->setMessage($message, 'error');
      }

      if (!empty($blog_title) && !empty($blog_body)) {
        // Blog model should save this blog entry.
        $blog_id = $this->blog_model->saveBlogEntry($blog_title, $blog_body);
        if (!empty($blog_id)) {
          $settings = new Settings();
          // Redirect the user to the detail page of this new blog entry.
          header('Location: ' . $settings->protocol . $settings->domain . '/index.php?action=blog-detail&id=' . $blog_id, 1);
        }
      }
    }
  }


  /**
   * Edit of a blog entry.
   * @throws \Exception
   */
  private function editBlogEntry()
  {

    // If the edit form was submitted.
    if (isset($_POST['submit']) && 'Save' == trim($_POST['submit'])) {
      if (isset($_POST['blog_id']) && !empty($_POST['blog_id'])) {
        // @todo security.
        $blog_id = $_POST['blog_id'];
        if (!empty($blog_id)) {
          // Update the blog entry with the new submited values.
          $this->updateBlogEntry();
        }
      }
    }
    else {
      // The blog entry edit form should be displayed.
      // Get the blog entry by the id, to get it's default values.
      if (isset($_GET['id']) && !empty($_GET['id']))
      {
        // @todo security.
        $blog_id = $_GET['id'];
        $this->blog_model->setBlogEntryByBlogId($blog_id);
      }

    }

  }


  /**
   * Update an existing blog entry.
   * @throws \Exception
   */
  private function updateBlogEntry() {

    if (isset($_POST['submit']) && 'Save' == trim($_POST['submit'])) {

      // @todo security.

      // Get the blog title from the post variables.
      if (isset($_POST['title']) && !empty($_POST['title'])) {
        $blog_title = $_POST['title'];
      }
      else {
        // Display a message if no title is given.
        $message = 'Please enter a blog title';
        $this->messages->setMessage($message, 'error');
      }

      // Get the blog body from the post variables.
      if (isset($_POST['body']) && !empty($_POST['body'])) {
        $blog_body = $_POST['body'];
      }
      else {
        // Display a message if no body is given.
        $message = 'Please enter a blog body';
        $this->messages->setMessage($message, 'error');
      }

      // Get the blog id from the post variables.
      if (isset($_POST['blog_id']) && !empty($_POST['blog_id'])) {
        $blog_id = $_POST['blog_id'];
      }
      else {
        // Exception, if the blog id is missing
        // as we cannot update the blog entry without it's id.
        throw new \Exception('Error - the blog id is missing.');
      }

      if (!empty($blog_title) && !empty($blog_body) && !empty($blog_id)) {
        // Blog model should save this blog entry.
        $this->blog_model->saveBlogEntry($blog_title, $blog_body, $blog_id);
        if (!empty($blog_id)) {
          $settings = new Settings();
          // Redirect the user to the detail page of this new blog entry.
          header('Location: ' . $settings->protocol . $settings->domain . '/index.php?action=blog-detail&id=' . $blog_id, 1);
        }
      }

    }

  }


}