<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css">
  <!--https://bulma.io/documentation/helpers/typography-helpers/-->
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
        <div class="field">
          <label class="label">Your name: </label>
          <div class="control">
            <input class="input" type="text" name="name"placeholder="Your Name">
          </div>
        </div>
        <div class="field">
          <label class="label">Your age: </label>
          <div class="control">
            <input class="input" type="text" name="age" placeholder="Your Age">
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input class="button is-link" type="submit" />
          </div>
        </div>
      </form>
    </div>
  </section>
</body>
</html>