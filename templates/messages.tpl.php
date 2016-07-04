<?php

  $classes = 'messages';
  $content = '';

  // Display messages
  if (!empty($messages)) {
    foreach ($messages as $type => $message_array) {

      if ('error' == $type) {
        $classes .= ' error';
      }

      if (!empty($message_array)) {
        foreach ($message_array as $message) {
          $content .= $message . '<br />' . PHP_EOL;
        }
      }
    }
  }
?>

<div class="messages <?php print $classes ?>">
  <?php print $content; ?>
</div>