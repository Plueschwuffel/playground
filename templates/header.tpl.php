<header>
    <div class="header-items">
      <a href="index.php">Startpage</a>


        <?php
          // If the user is logged in
          if (!empty($this->user->userIsLoggedIn()))
          {

            // Display add blog entry link
            print ' - <a href="index.php?action=add-blog-entry">Add blog entry</a>';

            // Display logout link
            print ' - <a href="index.php?action=logout">Logout</a>';

          }
          else {
            if ('login' != $_GET['action']) {
              // Display login button
              print ' - <a href="index.php?action=login">Login</a>';
            }
          }

        ?>

    </div>

</header>