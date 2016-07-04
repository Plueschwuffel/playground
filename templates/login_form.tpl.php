<section>
  <div id="login">
    <h2>Login Form</h2>

    <?php require_once 'messages.tpl.php'; ?>

    <form action="" method="post">
      <label>UserName :</label>
      <input id="name" name="username" placeholder="username" type="text">
      <label>Password :</label>
      <input id="password" name="password" placeholder="**********" type="password">
      <input name="submit" type="submit" value="Login">
    </form>
  </div>
</section>