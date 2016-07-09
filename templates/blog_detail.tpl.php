<div class="blog-entry-wrapper">
  <div class="blog-entry-detail">
    <div class="title">
      <h1><?php print $this->blog_model->current_blog_entry->title; ?></h1>
    </div>

    <?php
    // If the user is logged in
    if (!empty($this->user_model->userIsLoggedIn()))
    {
      ?>
      <a href="index.php?action=edit-blog-entry&id=<?php print $this->blog_model->current_blog_entry->blog_id; ?>">Edit blog entry</a>
    <?php
    }
    ?>

    <div class="blog-entry-meta" style="font-size: small; margin-bottom: 15px;">
      by <?php print $this->blog_model->current_blog_entry->username . ' - ' . date('d.m.Y H:i:s', $this->blog_model->current_blog_entry->created); ?>
    </div>
    <div class="blog-entry-body">
      <?php print $this->blog_model->current_blog_entry->body; ?>
    </div>
  </div>
</div>
