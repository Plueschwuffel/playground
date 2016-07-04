<?php
/**
 * @file
 * Blog model.
 */

namespace Playground\model;


class Blog {


  public function __construct() {
  }


  public function saveBlogEntry($blog_title, $blog_body) {

    if (!empty($blog_title) && !empty($blog_body)) {


      // @todo user model is missing.
      // Get the user id.
      $user_id = $this->user_model->getUserId();

    }

  }

}