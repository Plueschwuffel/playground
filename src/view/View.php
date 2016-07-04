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
  private $user;
  // The router controller object.
  private $router;
  // The messages model object.
  private $messages;


  /**
   * View constructor.
   * @param $user
   * @param $router
   */
  public function __construct($user, $router, $messages)
  {
    $this->user = $user;
    $this->router = $router;
    $this->messages = $messages;
  }

  /**
   * Display the page.
   */
  public function displayPage()
  {
    $this->setTemplatesByAction();
    $templates = $this->getTemplates();
    $messages = $this->messages->getMessages();
    require_once ('../templates/page.tpl.php');
  }


  /**
   * Preprocess the templates
   */
  public function setTemplatesByAction()
  {

    // Reset the templates.
    $this->templates = array();

    switch ($this->router->action)
    {

      // User login form.
      case 'login':
        if (!$this->user->userIsLoggedIn()) {
          $this->templates['content'] = 'login_form.tpl.php';
        }
        break;

      // Add blog entry form.
      case 'add-blog-entry':
        if ($this->user->userIsLoggedIn()) {
          $this->templates['content'] = 'add_blog_entry_form.tpl.php';
        }
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
    return $this->templates;
  }
  

}