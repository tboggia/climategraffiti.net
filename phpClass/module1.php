<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css">
  <title>Module 1 Notes</title>
</head>
<body>
  <section class="section">
    <div class="container">
      <h1 class="title">Module 1 Notes</h1>
      <ol>
        <li><a href="#manual">PHP Manual</a></li>
      </ol>
      <h2 id="manual">PHP Manual</h2>
      <p><code>php echo $_SERVER['HTTP_USER_AGENT'];</code></p>
      <p><?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>
      <p><a href="https://www.php.net/manual/en/reserved.variables.php">Other Reserved Variables</a></p>
      <hr/>
      <p>
        <code>
          if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
            echo 'You are using Internet Explorer.<br />';
          } else { echo 'You are not using Internet Explorer.<br />'; }
        </code>
      </p>
      <p>
      <?php 
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
          echo 'You are using Internet Explorer.<br />';
        } else { echo 'You are not using Internet Explorer.<br />'; }
      ?>
      </p>
      <hr />
      <form action="action.php" method="post">
        <p>Your name: <input type="text" name="name" /></p>
        <p>Your age: <input type="text" name="age" /></p>
        <p><input type="submit" /></p>
      </form>
    </div>
  </section>
</body>
</html>