<section>
  <div id="add-blog-entry">
    <h2>Add blog entry</h2>

    <?php require_once 'messages.tpl.php'; ?>

    <form action="" method="post">
      <div class="title">
        <label>Title:</label>
        <input id="title" name="title" placeholder="title" type="text" value="<?php print $variables['blog_title']; ?>">
      </div>
      <div class="body">
        <label>Body:</label>
        <textarea id="body" name="body" placeholder="body" rows="4" ><?php
            if (!empty($variables['blog_body'])) {
              print($variables['blog_body']);
            }
          ?></textarea>
      </div>
      <input id="blog_id" name="blog_id" type="hidden" value="<?php print $variables['blog_id']; ?>">
      <div class="buttons">
        <input name="submit" type="submit" value="Save">
      </div>
    </form>
  </div>
</section>