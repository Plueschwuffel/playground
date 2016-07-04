<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Playground</title>
</head>
<body>

<?php
  // Header
  require_once 'header.tpl.php';
?>

<hr>

<section>
  <div class="content">
    <?php require_once $templates['content']; ?>
  </div>
</section>



<hr>

<?php
  // FOOTER
  require_once 'footer.tpl.php';
?>


</body>
</html>