<h2>BLOG LIST</h2>

<?php
if (!empty($this->blog_model->blog_list)) {
  foreach ($this->blog_model->blog_list as $blog_id => $blog_entry) {
    ?>

    <div class="blog-entry-list">
      <div class="blog-entry">
        <div class="blog-entry-title">
          <a href="index.php?action=blog-detail&id= <?php print $blog_id ?> ">
            <h3><?php print $blog_entry->title; ?></h3>
          </a>
        </div>
        <div class="blog-entry-meta"
             style="font-size: small; margin-bottom: 15px;">
          by <?php print $blog_entry->username . ' - ' . date('d.m.Y H:i:s', $blog_entry->created); ?>
        </div>
        <div class="blog-entry-body">
          <?php print $blog_entry->body; ?>
        </div>
      </div>
    </div>

    <?php
  }
}
?>