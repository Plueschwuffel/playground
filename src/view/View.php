<?php
/**
 * @file
 * View
 */

namespace Playground\view;


//use Playground\controller\Router;
//use Playground\model\User;

/**
 * Class View
 * @package Playground\view
 */
class View {

  // Variable to handle the templates.
  private $templates;
  // The user model object
  private $user_model;
  // The blog model object
  private $blog_model;
  // The router controller object.
  private $router;
  // The messages model object.
  private $messages;


  /**
   * View constructor.
   * @param $user_model
   * @param $blog_model
   * @param $router
   * @param $messages
   */
  public function __construct($user_model, $blog_model, $router, $messages)
  {
    $this->user_model = $user_model;
    $this->blog_model = $blog_model;
    $this->router = $router;
    $this->messages = $messages;
  }

  /**
   * Display the page.
   */
  public function displayPage()
  {
    $templates = $this->getTemplates();
    // @todo use a public variable.
    $messages = $this->messages->getMessages();
    $variables = $this->preprocessPageVariables();
    require_once ('../templates/page.tpl.php');
  }

  /**
   * Preprocess page variables for the templates.
   */
  private function preprocessPageVariables() {

    $variables = array();

    // @todo preprocess the variables.

    // ----------------
    // Blog variables.
    // ----------------
    // Blog title.
    $variables['blog_title'] = '';
    if (!empty($this->blog_model->current_blog_entry->title)) {
      $variables['blog_title'] = trim($this->blog_model->current_blog_entry->title);
    }

    // Blog body.
    $variables['blog_body'] = '';
    if (!empty($this->blog_model->current_blog_entry->body)) {
      $variables['blog_body'] = trim($this->blog_model->current_blog_entry->body);
    }

    // Blog id.
    $variables['blog_id'] = '';
    if (!empty($this->blog_model->current_blog_entry->blog_id)) {
      $variables['blog_id'] = trim($this->blog_model->current_blog_entry->blog_id);
    }

    return $variables;
  }


  /**
   * Select the templates to be displayed.
   */
  private function setTemplatesByAction()
  {

    // Reset the templates.
    $this->templates = array();

    switch ($this->router->action)
    {

      // User login form.
      case 'login':
        if (!$this->user_model->userIsLoggedIn()) {
          $this->templates['content'] = 'login_form.tpl.php';
        }
        break;

      // Add blog entry form.
      // Edit blog entry form.
      case 'add-blog-entry':
      case 'edit-blog-entry':
        if ($this->user_model->userIsLoggedIn()) {
          $this->templates['content'] = 'add_blog_entry_form.tpl.php';
        }
        break;

      // Blog entry detail page.
      case 'blog-detail':
        $this->templates['content'] = 'blog_detail.tpl.php';
        break;

    }

    // Default template = list the blog entries.
    if (empty($this->templates['content'])) {
      $this->templates['content'] = 'blog_list.tpl.php';
    }

  }

  /**
   * Get the templates.
   * @return mixed
   */
  private function getTemplates() {
    // Select the templates to be displayed by the current action.
    $this->setTemplatesByAction();
    return $this->templates;
  }
  

}