<html>
 <head>
  <title>Module 1 Notes</title>
 </head>
 <body>
    <h1>Module 1 Notes</h1>
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
     
 </body>
</html>